<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Welcome to CMS</title>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'><link rel="stylesheet" href="CSS/styleindex.css">
<style>
  /* .carousel-container {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }
    
    .carousel-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      animation: carouselAnimation 10s infinite;
      filter: blur(5px); /*  
    }*/
    .greeting-message {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.6);
      color: white;
      font-size: 24px;
      border: 3px solid white;
      border-radius: 10px;
    }

    .carousel-container {
  position: relative;
  width: 100%;
  height: 100vh;
  overflow: hidden;
  background: rgb(238,174,202);
background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%); /* Add a background color to prevent white flash */
}

.carousel-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  animation: carouselAnimation 15s infinite;
  filter: blur(3px); /* Adjust the blur amount as per your preference */
  opacity: 0; /* Start with opacity set to 0 */
}

@keyframes carouselAnimation {
  0% {
    opacity: 0;
  }
  25% {
    opacity: 1;
    background-image: url(image/bg1.jpg);
  }
  50% {
    opacity: 1;
    background-image: url(image/bg2.jpg);
  }
  75% {
    opacity: 1;
    background-image: url(image/bg3.jpg);
  }
  100% {
    opacity: 1;
    background-image: url(image/bg4.jpg);
  }
}
    
    /* @keyframes carouselAnimation {
      0% {
        opacity: 1;
      }
      20% {
        opacity: 0;
      }
      25% {
        opacity: 0;
        background-image: url(image/bg1.jpg);
      }
      45% {
        opacity: 1;
      }
      70% {
        opacity: 1;
      }
      75% {
        opacity: 0;
      }
      80% {
        opacity: 0;
        background-image: url(image/bg2.jpg);
      }
      100% {
        opacity: 1;
      }
    } */
  </style>
</head>
<body>
<!-- partial:index.partial.html -->
<input type="checkbox" id="checkbox" /><label class="fa fa-bars fa-2x" for="checkbox"></label>
<nav role='navigation'>
  <ul class="nav">
    <li><a href="#page-home">Home</a></li>
    <li><a href="admin/admin_login.php">Admin Login</a></li>
    <li><a href="course_manager/login.php">Course Manager Login</a></li>
    <li><a href="student/login.php">Students Login</a></li>
    <li><a href="#page-about">About Us</a></li>
    <li><a href="#page-contact">Contact Us</a></li>
  </ul>
  <ul class="soc-media">
    <li><a href="#" class="fa fa-twitter"></a></li>
    <li><a href="#" class="fa fa-facebook"></a></li>
    <li><a href="#" class="fa fa-google-plus"></a></li>
  </ul>
</nav>
<main class="wrapper">
<div class="carousel-container">
    <div class="carousel-image"></div>
    <div class="greeting-message">
      <h1>Hello and welcome to CMS!</h1>
      <p>Unlock your potential and excel in your engineering studies</p>
    <p>Explore our wide range of courses and empower your future</p>
    </div>
  </div>
  
  <section class="home" id="page-home"></section>
  <section class="about" id="page-about" style="font-size: 20px;">
    <div class="content">
    <h1>About Us</h1>
    <p>At our Course Management System (CMS), we are dedicated to providing high-quality engineering courses tailored to meet the needs of aspiring engineers. We believe in empowering students with the knowledge and skills required to succeed in their academic and professional journeys.</p>
    <p>Our team of experienced instructors and industry experts design and curate comprehensive course materials, ensuring that each course encompasses the fundamental concepts and advanced topics necessary for a well-rounded education. We cover a wide range of engineering disciplines, including but not limited to mechanical engineering, electrical engineering, civil engineering, and computer science.</p>
    <p>One of our key commitments is to make education accessible to all. Alongside our courses, we provide a vast collection of free engineering books, covering various subjects and offering valuable resources for self-study and reference.</p>
    <p>Whether you are a student seeking to supplement your university curriculum, a working professional looking to expand your knowledge, or an aspiring engineer eager to embark on your learning journey, our CMS is here to support you. Join our community of learners today and unlock the doors to a successful future in engineering!</p>
    </div>
  </section>
  <section class="contact" id="page-contact">
  <div class="content" style="font-size: 20px;">
    <h1>Contact Us</h1>
    <p>We would love to hear from you! If you have any questions, suggestions, or inquiries regarding our engineering courses or any other aspect of our Course Management System, please feel free to reach out to us.</p>
    <p>You can contact us through the following methods:</p>
    <ul>
      <li><strong>Email:</strong> info@cmsengineering.com</li>
      <li><strong>Phone:</strong> +1 123-456-7890</li>
      <li><strong>Address:</strong> 123 Main Street, City, State, Zip Code</li>
    </ul>
    <p>Our dedicated support team is available during business hours to assist you and provide prompt responses to your queries. We value your feedback and strive to continuously improve our CMS to better serve the engineering community.</p>
    <p>Connect with us on social media to stay updated with the latest news, course releases, and industry insights:</p>
    
  </div>
</section>

  
  
</main>
<!-- partial -->
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="./script.js"></script>

</body>
</html>
