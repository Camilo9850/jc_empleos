<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>{{ $titulo }} -  {{ env('APP_NAME') }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.min.css') }}" rel="stylesheet" type="text/css">
    <!-- FontAwesome 6.6.0 desde CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/funciones_generales.js') }}"></script>
    <style>
      body {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      
      .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      .card-login {
        width: 100%;
        max-width: 400px;
        border: none;
        border-radius: 15px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
      }
      
      .card-header {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        text-align: center;
        padding: 2rem 1.5rem 1rem;
        border: none;
        font-size: 1.25rem;
        font-weight: 600;
      }
      
      .logo-container {
        text-align: center;
        margin-bottom: 1rem;
      }
      
      .logo-container img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }
      
      .card-body {
        padding: 2rem;
      }
      
      .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
      }
      
      .form-control:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
      }
      
      .btn-primary {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
      
      .btn-primary:hover {
        background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
      }
      
      .checkbox label {
        color: #6c757d;
        font-size: 14px;
      }
      
      .text-center a {
        color: #dc3545;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
      }
      
      .text-center a:hover {
        color: #c82333;
      }
      
      .form-label-group {
        position: relative;
        margin-bottom: 1rem;
      }
      
      .form-label-group label {
        position: absolute;
        top: 12px;
        left: 15px;
        color: #6c757d;
        font-size: 14px;
        transition: all 0.3s ease;
        pointer-events: none;
      }
      
      .form-label-group input:focus + label,
      .form-label-group input:not(:placeholder-shown) + label {
        top: -8px;
        left: 10px;
        font-size: 12px;
        color: #dc3545;
        background: white;
        padding: 0 5px;
      }
    </style>
  </head>
  
<body>
    <div class="login-container">
      <div class="card card-login">
        <div class="card-header">
          <div class="logo-container">
            <img src="{{ asset('img/jc.png') }}" alt="Logo"  height="100px" width="50px"class="logo">
          </div>
          <i class="fas fa-lock"></i> Acceso al Sistema
        </div>
        <div class="card-body">
          <?php
          if (isset($msg)) {
              echo '<div id = "msg"></div>';
              echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
          }
          ?>
          <form name="fr" class="form-signin" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="txtUsuario" name="txtUsuario" class="form-control" placeholder=" " required autofocus>
                <label for="txtUsuario"><i class="fas fa-user"></i> Usuario</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder=" " required>
                <label for="txtClave"><i class="fas fa-key"></i> Clave</label>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  <i class="fas fa-check-square text-danger"></i> Recordar clave
                </label>
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">
              <i class="fas fa-sign-in-alt"></i> Entrar
            </button>
          </form><br>
          <div class="text-center">
            <a class="d-block small" href="/admin/recupero-clave">
              <i class="fas fa-key"></i> Recuperar clave
            </a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>