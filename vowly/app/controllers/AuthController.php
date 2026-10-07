<?php
class AuthController extends Controller {
    public function loginForm(): void {
        if (Auth::check()) redirect('dashboard');
        $this->view('auth/login', ['email' => '']);
    }
    public function login(): void {
        $email = post('email');
        $u = User::byEmail($email);
        if (!$u || !password_verify(post('password'), $u['password_hash'])) {
            flash('error', 'Email or password is incorrect.');
            $this->view('auth/login', ['email' => $email]);
            return;
        }
        Auth::login((int)$u['id']);
        redirect('dashboard');
    }
    public function registerForm(): void {
        if (Auth::check()) redirect('dashboard');
        $this->view('auth/register', ['old' => ['name' => '', 'email' => ''], 'errors' => []]);
    }
    public function register(): void {
        $old = ['name' => post('name'), 'email' => post('email')];
        $pass = post('password');
        $err = [];
        if ($old['name'] === '') $err[] = 'Enter your name.';
        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $err[] = 'Enter a valid email address.';
        elseif (User::byEmail($old['email'])) $err[] = 'That email already has an account. Log in instead.';
        if (strlen($pass) < 8) $err[] = 'Use a password with at least 8 characters.';
        if ($pass !== post('password2')) $err[] = 'The two passwords do not match.';
        if ($err) { $this->view('auth/register', ['old' => $old, 'errors' => $err]); return; }
        Auth::login(User::create($old['name'], $old['email'], $pass));
        flash('ok', 'Account created. Start by naming your wedding site.');
        redirect('dashboard');
    }
    public function logout(): void { Auth::logout(); session_start(); redirect(''); }
}
