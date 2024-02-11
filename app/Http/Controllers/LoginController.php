<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Mail;

class LoginController extends Controller
{
    public function index(){
        $loginCookie = (isset($_COOKIE['CkLogin'])) ? 
        base64_decode($_COOKIE['CkLogin']) : '';
        $senhaCookie = (isset($_COOKIE['CkSenha'])) ? 
        base64_decode($_COOKIE['CkSenha']) : '';
        $lembrarCookie = (isset($_COOKIE['CkLembrar'])) ? 
        $_COOKIE['CkLembrar'] : '';
        return view('login', compact('loginCookie', 'senhaCookie', 'lembrarCookie'));
    }

    public function login(Request $request){
        $login = $request->login;
        $senha = $request->senha;
        $user = User::where('email', $login)
        ->where('senha', md5($senha))
        ->first();

        $redirecionarPagamento = false;
        if($user != null){

            $lembrar = $request->lembrar;
            if($lembrar){
                $expira = time() + 60*60*24*30;
                setCookie('CkLogin', base64_encode($login), $expira);
                setCookie('CkSenha', base64_encode($senha), $expira);
                setCookie('CkLembrar', 1, $expira);
            }else{
                setCookie('CkLogin');
                setCookie('CkSenha');
                setCookie('CkLembrar');
            }


            $session = [
                'user' => $user,
                'ip_address' => $this->get_client_ip()
            ];

            session(['user_logged' => $session]);
            
            session()->flash("flash_sucesso", "Bem vindo(a) $user->nome");
            return redirect('/rifas');

        }else{
            session()->flash("flash_erro", "Credencias inválidas!");
            return redirect()->back();
        }
    }

    private function saveAccess($aluno, $ip){
        AlunoAcesso::create([
            'aluno_id' => $aluno->id,
            'ip' => $ip
        ]);
    }


    private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function logoff(){
        session()->forget('user_logged');
        session()->flash('flash_sucesso', 'Logoff realizado.');
        return redirect("/login");
    }

}
