<?php

namespace App\Http\Controllers\Auth\User;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

enum PreferredType: string
{
    case SCHEME = 'scheme_based_profile';
    case DISCOUNT = 'net_discount_profile';
}

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);

        // Validate all form fields
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email|max:191',
            'phone' => 'required|string|unique:users,phone|max:191',
            'address' => 'required|string|max:191',
            'country' => 'required|string|max:100',
            'state' => 'nullable|integer', // Expecting state_id
            'city' => 'nullable|integer', // Expecting city_id
            'hcp_clinic_name' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
            'doctor_qualification' => 'required|string|max:255',
            'preferred_type' => ['required', new Enum(PreferredType::class)],
            'password' => 'required|confirmed|min:6',
        ]);

        // Test database connection
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return back()->withErrors(['db_error' => 'Cannot connect to the database: ' . $e->getMessage()]);
        }

        $user = new User;
        $input = $request->all();

        // Map form fields to database columns
        $input['password'] = bcrypt($request['password']);
        $input['verification_link'] = md5(time() . $request->name . $request->email);
        $input['affilate_code'] = md5($request->name . $request->email);
        $input['state_id'] = $request->input('state'); // Map state to state_id
        $input['city_id'] = $request->input('city');   // Map city to city_id

        if (!empty($request->vendor)) {
            $request->validate([
                'shop_name' => 'unique:users',
                'shop_number' => 'max:10',
            ], [
                'shop_name.unique' => __('This Shop Name has already been taken.'),
                'shop_number.max' => __('Shop Number Must Be Less Then 10 Digit.'),
            ]);

            $input['is_vendor'] = 1;
        }

        $input['ban'] = 1; // Set to true (boolean cast in User model)

        // Save the user with error handling
        try {
            $user->fill($input);
            if (!$user->save()) {
                return back()->withErrors(['db_error' => 'Failed to save user to the database.']);
            }
        } catch (QueryException $e) {
            return back()->withErrors(['db_error' => 'Database error: ' . $e->getMessage()]);
        }

        if ($gs->is_verification_email == 1) {
            $to = $request->email;
            $subject = 'Verify your email address.';
            $msg = "Dear Customer,<br>We noticed that you need to verify your email address.<br>Simply click the link below to verify. <a href=" . url('user/register/verify/' . $input['verification_link']) . ">" . url('user/register/verify/' . $input['verification_link']) . "</a>";

            $data = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);

            return back()->with('success', 'We need to verify your email address. We have sent an email to ' . $to . ' to verify your email address. Please click the link in that email to continue.');
        } else {
            $user->email_verified = 'Yes';
            $user->update();

            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->save();

            $data = [
                'to' => $user->email,
                'type' => "new_registration",
                'cname' => $user->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'onumber' => "",
            ];
            $mailer = new GeniusMailer();
            $mailer->sendAutoMail($data);

            // Since ban is cast as boolean, true means the user is banned
            if ($user->ban) {
                return redirect()->route('user.login')->with('success', __('Registration Successful'));
            } else {
                Auth::login($user);
                return redirect()->route('user-dashboard')->with('success', __('Registration Successful'));
            }
        }
    }

    public function token($token)
    {
        $gs = Generalsetting::findOrFail(1);

        if ($gs->is_verification_email == 1) {
            $user = User::where('verification_link', '=', $token)->first();
            if (isset($user)) {
                $user->email_verified = 'Yes';
                $user->update();

                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->save();

                $data = [
                    'to' => $user->email,
                    'type' => "new_registration",
                    'cname' => $user->name,
                    'oamount' => "",
                    'aname' => "",
                    'aemail' => "",
                    'onumber' => "",
                ];
                $mailer = new GeniusMailer();
                $mailer->sendAutoMail($data);

                Auth::login($user);
                return redirect()->route('user-dashboard')->with('success', __('Email Verified Successfully'));
            }
        }
        return redirect()->back();
    }
}