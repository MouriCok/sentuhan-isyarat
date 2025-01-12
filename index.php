<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sentuhan Isyarat</title>
        <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/x-icon" href="dist/assets/img/SI_icon.png" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="dist/css/stylesss.css" rel="stylesheet" />
        <link href="dist/css/card.css" rel="stylesheet" />
        <style>
            #charCounter {
                transition: color 0.2s ease, font-weight 0.2s ease;
            }
            .logoutBtn {
                color: red;
            }
            .navbar-nav {
                background-color:rgba(33, 37, 41, 0.5);
                border-radius: 10px;
                padding: 0 20px;
            }
        </style>
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="#page-top"><img src="dist/assets/img/SI_navbar.png" alt="Sentuhan Isyarat" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo htmlspecialchars($_SESSION['username']); ?> <!-- Display logged-in username -->
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <!-- <li><a class="dropdown-item" href="profile.php">Profile</a></li> -->
                                    <li><a class="dropdown-item logoutBtn" href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.html">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">Welcome To Sentuhan Isyarat!</div>
                <div class="masthead-heading text-uppercase">We help you communicate through your webcam</div>
                <a class="btn btn-primary btn-xl text-uppercase" href="#services">Explore More</a>
            </div>
        </header>
        <!-- services Grid-->
        <section class="page-section bg-light" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Services</h2>
                    <h3 class="section-subheading text-muted">We provide you a webcam that can detect your gestures.</h3>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- services item 1-->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal1">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <div class="detectOnClick">
                                    <img class="img-fluid" src="https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/e822e597416349.5ec5ba8231fb4.jpg" width="100%" height="100%" crossorigin="anonymous" alt="Hand Landmark" />
                                </div>
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><strong>Hand Landmark</strong></div>
                                <div class="portfolio-caption-subheading text-muted">We put a hand landmark on your webcam to detect your gestures and show it to you on the screen in real time by using <u>MediaPipe</u>.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- services item 2-->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal2">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <div class="detectOnClick">
                                    <img class="img-fluid" src="https://assets.codepen.io/9177687/hand-ge4ca13f5d_1920.jpg" width="100%" height="100%" crossorigin="anonymous" alt="..." />
                                </div>
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><strong>Landmark Demonstration</strong></div>
                                <div class="portfolio-caption-subheading text-muted"><u>Click the image above</u> to see the hand landmark appear and detect the hand in the image.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- services item 3-->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal3">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <div class="imgSideDetect">
                                    <img class="img-fluid" src="./dist/assets/img/sign-talking.png" width="100%" height="100%" crossorigin="anonymous" alt="..." />
                                </div>
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><strong>WebCam Detection</strong></div>
                                <div class="portfolio-caption-subheading text-muted">Our WebCam will detect your gestures, predict the sign, and show it to you on the screen in real time. </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <a class="btn btn-outline-primary btn-xm text-uppercase" href="detection.html">Try Our WebCam</a>
                </div>
            </div>
        </section>
        <!-- About-->
        <section class="page-section" id="about">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">About</h2>
                    <h3 class="section-subheading text-muted">Empowering communication through technology.</h3>
                </div>
                <ul class="timeline">
                    <li>
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="dist/assets/img/about/1.jpeg" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>2023</h4>
                                <h4 class="subheading">The Beginning</h4>
                            </div>
                            <div class="timeline-body">
                                <p class="text-muted">
                                    This project started with a simple yet powerful idea: to bridge the gap in communication for the hearing-impaired community using modern technology. Combining passion for accessibility and artificial intelligence, the groundwork for this platform was laid.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="dist/assets/img/hand_landmark.png" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>2023</h4>
                                <h4 class="subheading">Building the Foundation</h4>
                            </div>
                            <div class="timeline-body">
                                <p class="text-muted">
                                    Leveraging <u>TensorFlow.js</u> and <u>MediaPipe</u>, we created an application that detects and predicts sign language alphabets in real-time. Early versions focused on establishing reliable hand landmark detection and gesture prediction.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="dist/assets/img/about/3.jpg" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>2024</h4>
                                <h4 class="subheading">Community Involvement</h4>
                            </div>
                            <div class="timeline-body">
                                <p class="text-muted">
                                    A major milestone was enabling users to contribute their own datasets. This feature empowered the community to train custom models using their unique sign gestures, making the application more inclusive and personalized.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="dist/assets/img/about/4.jpg" alt="..." /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>Future Goals</h4>
                                <h4 class="subheading">Expanding Horizons</h4>
                            </div>
                            <div class="timeline-body">
                                <p class="text-muted">
                                    The next phase aims to incorporate sentence prediction and multilingual sign language support. We envision a world where technology can break down communication barriers, fostering greater understanding and inclusion.
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image">
                            <h4>
                                Join Us
                                <br />
                                On This
                                <br />
                                Journey!
                            </h4>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- Contact-->
        <section class="page-section" id="contact">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Contact Us</h2>
                    <h3 class="section-subheading text-muted">We would love to hear from you!</h3>
                </div>
                <br>
                <form id="contactForm" action="contact.php" method="POST">
                    <div class="row align-items-stretch mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- Name input-->
                                <input class="form-control" name="name" type="text" placeholder="Your Name *" required />
                            </div>
                            <div class="form-group">
                                <!-- Email address input-->
                                <input class="form-control" name="email" type="email" placeholder="Your Email *" required />
                            </div>
                            <div class="form-group">
                                <!-- Phone number input-->
                                <input class="form-control" name="phone" type="tel" placeholder="Your Phone *" required />
                            </div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <div class="form-group form-group-textarea mb-md-0">
                                <!-- Message input -->
                                <textarea 
                                    class="form-control" 
                                    name="message" 
                                    placeholder="Your Message *" 
                                    style="height: 246px;" 
                                    maxlength="1001" 
                                    required
                                    id="messageTextarea"></textarea>
                                <!-- Live character counter -->
                                <small 
                                    id="charCounter" 
                                    class="form-text position-absolute" 
                                    style="bottom: 0px; left: 15px; color: #fff;">
                                    0/1000
                                </small>
                            </div>
                        </div>                                              
                    </div>
                    <!-- Submit Button-->
                    <div class="text-center">
                        <button class="btn btn-primary btn-xl text-uppercase" type="submit">Send Message</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Contact Modal -->
        <div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">Message Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="responseMessage">
                        <!-- Message content will be injected here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer-->
        <footer class="footer py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-start">Copyright &copy; Sentuhan Isyarat 2023</div>
                    <div class="col-lg-4 my-3 my-lg-0">
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                        <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                    </div>
                </div>
            </div>
        </footer>
        
        <script>
            const textarea = document.getElementById("messageTextarea");
            const charCounter = document.getElementById("charCounter");
            const maxLength = 1000;

            textarea.addEventListener("input", () => {
                const currentLength = textarea.value.length;

                // Update character counter text
                charCounter.textContent = `${currentLength}/${maxLength}`;

                // Validation: If character count exceeds the limit
                if (currentLength > maxLength) {
                    charCounter.style.color = "red"; // Change counter color to red
                    charCounter.style.fontWeight = "bold"; // Make it bold
                } else {
                    charCounter.style.color = "#fff"; // Default muted color
                    charCounter.style.fontWeight = "normal"; // Normal font weight
                }
            });

            const form = document.getElementById("contactForm");
            const responseModal = new bootstrap.Modal(document.getElementById("responseModal"));
            const responseMessage = document.getElementById("responseMessage");

            form.addEventListener("submit", async (event) => {
                event.preventDefault(); // Prevent default form submission behavior

                // Gather form data
                const formData = new FormData(form);

                try {
                    // Send form data to PHP
                    const response = await fetch(form.action, {
                        method: "POST",
                        body: formData,
                    });

                    const result = await response.json(); // Parse JSON response
                    responseMessage.textContent = result.message;

                    // Show modal
                    responseModal.show();

                    // Reset form on success
                    if (result.status === "success") {
                        form.reset();
                    }
                } catch (error) {
                    responseMessage.textContent = "An error occurred. Please try again.";
                    responseModal.show();
                }
            });
        </script>
        <!-- Core theme JS-->
        <script src="dist/js/scroll.js"></script>
        <script type="module" src="./script.js"></script>
    </body>
</html>
