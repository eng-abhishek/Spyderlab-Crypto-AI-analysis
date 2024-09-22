<?php

namespace App\Http\Controllers\Frontend\Auth;

use Elliptic\EC;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use kornrunner\Keccak;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Web3LoginController
{
    public function message()
    {
        $nonce = Str::random();
        $message = "I am connecting my wallet to SpyderLab, \n\nNonce: " . $nonce;

        session()->put('sign_message', $message);

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function verify(Request $request)
    {
        $result = $this->verifySignature(session()->pull('sign_message'), $request->input('signature'), $request->input('address'));

        if($result){

            $user = User::where('eth_address', $request->get('address'))->first();
            if(!$user){
                $user = new User;
                $user->eth_address = $request->get('address');
                $user->email_verified_at = now();
                $user->is_active = 'Y';
                $user->save();
            }

            Auth::login($user);

            if($request->ajax()){
                return response()->json(['status' => 'success', 'redirect_to' => route('workspace')]);
            }
            return redirect()->route('workspace')->with(['status' => 'success', 'message' => 'Login successfully using wallet.']);
        }else{
            if($request->ajax()){
                return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again later.']);
            }
            return redirect()->route('workspace')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again later.']);
        }
    }

    protected function verifySignature(string $message, string $signature, string $address): bool
    {
        $hash = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);
        $sign = [
            'r' => substr($signature, 2, 64),
            's' => substr($signature, 66, 64),
        ];
        $recid = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recid != ($recid & 1)) {
            return false;
        }

        $pubkey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recid);
        $derived_address = '0x' . substr(Keccak::hash(substr(hex2bin($pubkey->encode('hex')), 1), 256), 24);

        return (Str::lower($address) === $derived_address);
    }
}