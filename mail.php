<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pfad zu Composer Autoloader

// Variables for page display
$success = false;
$error = false;
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Daten aus Formular holen und absichern
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $service = htmlspecialchars(trim($_POST['service'] ?? ''));
    $messageText = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (!$name || !$email || !$service || !$messageText) {
        $error = true;
        $message = "Bitte alle Felder ausfüllen.";
    } else {
        $mail = new PHPMailer(true);

        try {
            // SMTP Konfiguration (Beispiel Gmail)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sender.phpmail.order@gmail.com'; // deine Gmail-Adresse
            $mail->Password = 'fkvu trzq mqzp jsjb'; // App-Passwort, kein normales Passwort
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Absender und Empfänger
            $mail->setFrom('sender.phpmail.order@gmail.com', 'Webshop Contact Form');
            $mail->addAddress('gabriel.knaudr@gmail.com'); // Empfänger
            $mail->addReplyTo($email, $name);

            // Inhalt
            $mail->isHTML(true);
            $mail->Subject = 'Eingang von Bestellung / Anfrage' . $service;
            $mail->Body = "
            <h2>Neue Kontaktanfrage</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Service:</strong> $service</p>
            <p><strong>Nachricht:</strong></p>
            <p>$messageText</p>
            ";
            $mail->AltBody = "Name: $name\nEmail: $email\nService: $service\nNachricht:\n$messageText";

            $mail->send();
            $success = true;
            $message = "Vielen Dank! Ihre Nachricht wurde erfolgreich gesendet. Wir werden uns bald bei Ihnen melden.";
        } catch (Exception $e) {
            $error = true;
            $message = "Fehler beim Senden der Nachricht. Bitte versuchen Sie es später erneut oder kontaktieren Sie uns direkt.";
        }
    }
} else {
    $error = true;
    $message = "Ungültige Anfrage. Bitte verwenden Sie das Kontaktformular.";
}
?>
<!doctype html>
<html lang="de" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kontakt - My Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hover-lift {
            transition: transform 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 1s ease-out;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-delay-200 {
            animation-delay: 200ms;
        }
        
        .animate-delay-400 {
            animation-delay: 400ms;
        }
        
        .animate-delay-600 {
            animation-delay: 600ms;
        }
        
        .animate-delay-800 {
            animation-delay: 800ms;
        }
    </style>
</head>
<body class="bg-gradient-to-bl from-gray-900 via-purple-900 to-black min-h-screen text-white">
    <header class="fixed top-0 left-0 w-full bg-purple-900/90 backdrop-blur-lg p-6 shadow-lg z-50 animate-fadeInUp">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-extrabold tracking-wide text-white drop-shadow-lg animate-float">
                <a href="/">My Shop</a>
            </h1>
            <nav>
                <ul class="flex space-x-8 text-lg font-semibold">
                    <li><a href="/#home" class="hover:underline hover:text-purple-300 transition animate-fadeInUp animate-delay-200">Home</a></li>
                    <li><a href="/#services" class="hover:underline hover:text-purple-300 transition animate-fadeInUp animate-delay-400">Services</a></li>
                    <li><a href="/#portfolio" class="hover:underline hover:text-purple-300 transition animate-fadeInUp animate-delay-600">Portfolio</a></li>
                    <li><a href="/#contact" class="hover:underline hover:text-purple-300 transition animate-fadeInUp animate-delay-800">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="pt-32 max-w-4xl mx-auto px-6 min-h-screen flex items-center justify-center">
        <div class="glass rounded-3xl p-12 w-full animate-fadeInUp">
            <div class="text-center">
                <?php if ($success): ?>
                    <!-- Success Message -->
                    <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-8 animate-float">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold mb-6 text-green-400">Nachricht gesendet!</h1>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed"><?php echo $message; ?></p>
                    
                    <div class="space-y-4 text-gray-300 mb-8">
                        <p class="text-lg"><strong>Was passiert als nächstes?</strong></p>
                        <ul class="space-y-2">
                            <li class="flex items-center justify-center">
                                <span class="text-purple-400 mr-2">1.</span>
                                Wir überprüfen Ihre Anfrage innerhalb von 24 Stunden
                            </li>
                            <li class="flex items-center justify-center">
                                <span class="text-purple-400 mr-2">2.</span>
                                Sie erhalten ein individuelles Angebot per E-Mail
                            </li>
                            <li class="flex items-center justify-center">
                                <span class="text-purple-400 mr-2">3.</span>
                                Wir besprechen die Details in einem kostenlosen Beratungsgespräch
                            </li>
                        </ul>
                    </div>
                    
                <?php else: ?>
                    <!-- Error Message -->
                    <div class="w-24 h-24 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-8">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold mb-6 text-red-400">Fehler aufgetreten</h1>
                    <p class="text-xl text-gray-300 mb-8"><?php echo $message; ?></p>
                    
                    <div class="glass rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-purple-300">Alternative Kontaktmöglichkeiten:</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-center">
                                <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-300">gabriel.knaudr@gmail.com</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                <span class="text-gray-300">+43 123 456 789</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="flex gap-4 justify-center">
                    <a href="/" class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transition rounded-lg px-8 py-4 font-semibold shadow-lg hover:shadow-purple-400 transform hover:scale-105 text-center hover-lift">
                        Zurück zur Startseite
                    </a>
                    <?php if ($error): ?>
                        <a href="/#contact" class="inline-block bg-transparent border-2 border-purple-400 hover:bg-purple-400 transition rounded-lg px-8 py-4 font-semibold text-center hover-lift">
                            Erneut versuchen
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Additional Info Section -->
                <?php if ($success): ?>
                <div class="mt-12 glass rounded-xl p-6">
                    <h3 class="text-xl font-semibold mb-4 text-purple-300">Warum My Shop?</h3>
                    <div class="grid md:grid-cols-3 gap-4 text-sm text-gray-300">
                        <div class="text-center">
                            <div class="text-2xl font-bold gradient-bg bg-clip-text text-transparent mb-2">150+</div>
                            <div>Zufriedene Kunden</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold gradient-bg bg-clip-text text-transparent mb-2">98%</div>
                            <div>Kundenzufriedenheit</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold gradient-bg bg-clip-text text-transparent mb-2">24/7</div>
                            <div>Support verfügbar</div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="mt-32 bg-black/50 backdrop-blur-lg border-t border-purple-400/20">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 animate-float">My Shop</h3>
                    <p class="text-gray-400">Creating stunning websites that drive results for your business.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-purple-300 transition">Web Design</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition">E-commerce</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition">SEO Optimization</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition">Maintenance</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-purple-300 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition">Portfolio</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition">Careers</a></li>
                        <li><a href="#" class="hover:text-purple-300 transition">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition hover-lift">
                            <span class="font-bold">f</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition hover-lift">
                            <span class="font-bold">@</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center hover:bg-purple-700 transition hover-lift">
                            <span class="font-bold">in</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-purple-400/20 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 My Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Optional: Auto redirect after successful submission (uncomment if desired)
        <?php if ($success): ?>
        // setTimeout(() => {
        //     window.location.href = '/';
        // }, 10000); // Redirect after 10 seconds
        <?php endif; ?>

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html> 