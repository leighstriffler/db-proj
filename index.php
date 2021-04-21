<link type="text/css" rel="stylesheet" href="/stylesheets/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

<?php
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
   case '/':                   // URL (without file name) to a default screen
      require 'login.php';
      break;
   case '/login.php':     // if you plan to also allow a URL with the file name
      require 'login.php';
      break;
   case '/register.php':
      require 'register.php';
      break;
    case '/browse.php':
       require 'browse.php';
       break;
     case '/search.php':
        require 'search.php';
        break;
      case '/profile.php':
         require 'profile.php';
         break;
     case '/acctinfo.php':
        require 'acctinfo.php';
        break;
      default:
      http_response_code(404);
      exit('Not Found');
}
?>
