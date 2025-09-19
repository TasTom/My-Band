<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Contact - TP2 PHP Par TAS Tom</title>
    <link rel="stylesheet" href="component/header.css">
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <?php require_once 'component/header.php'; ?>
    
    <?php
        require_once 'connection.php';
        
        $message_sent = false;
        $error_message = '';
        
        // Traitement du formulaire de contact
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $subject = trim($_POST['subject']);
            $message = trim($_POST['message']);
            
            // Validation des champs
            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $error_message = "Tous les champs sont obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_message = "Format d'email invalide.";
            } else {
                try {
                    // 1. Récupérer l'email de l'admin ayant contact = 1
                    $stmt_admin = $connect->prepare(
                        "SELECT nom, prenom, mail FROM admin WHERE contact = 1 LIMIT 1");
                    $stmt_admin->execute();
                    $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$admin) {
                        $error_message = "Aucun administrateur disponible pour recevoir les messages.";
                    } else {
                        // 2. Insertion en base de données
                        $stmt = $connect->prepare(
                            "INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
                        $stmt->execute([$name, $email, $subject, $message]);
                        
                        // 3. BONUS : Envoi d'email à l'admin
                        $admin_email = $admin['mail'];
                        $admin_name = $admin['prenom'] . ' ' . $admin['nom'];
                        
                        // Préparation du contenu de l'email
                        $email_subject = "[CONTACT SITE] " . $subject;
                        $email_body = "
                        Nouveau message de contact :

                        Nom : $name
                        Email : $email  
                        Sujet : $subject

                        Message :
                        $message
                        ";

                        // Log du message au lieu de l'envoyer par email
                        $log_message = date('[Y-m-d H:i:s] ') . "EMAIL TO: $admin_email\n";
                        $log_message .= "SUBJECT: $email_subject\n";
                        $log_message .= "BODY: $email_body\n\n";

                        // Enregistrer dans un fichier log (optionnel)
                        file_put_contents('contact_emails.log', $log_message, FILE_APPEND | LOCK_EX);

                        // Simuler le succès de l'envoi
                        $mail_sent = true; // Simulation
                        $message_sent = true;

                        }

                        $message_sent = true;
                    }catch (PDOException $e) {
                    $error_message = "Erreur lors de l'envoi du message. Veuillez réessayer.";
                }
            }
        }
    ?>
    
    <main class="contact-container">
        <div class="contact-header">
            <h1>Contact us</h1>
            <p>Do you have any questions? You need a guide?</p>
        </div>
        
        <div class="contact-content">
            <div class="contact-form-section">
            <?php if ($message_sent): ?>
                    <div class="success-message">
                        <h3>✅ Message envoyé avec succès !</h3>
                        <p>Merci <strong><?php echo htmlspecialchars($name); ?></strong> pour votre message.</p>
                        <p>Votre message a été transmis à <strong><?php echo htmlspecialchars($admin['prenom'] . ' ' . $admin['nom']); ?></strong>.</p>
                        <p>Nous vous répondrons à : <strong><?php echo htmlspecialchars($email); ?></strong></p>
                        
                        <div class="email-status">
                            <p class="email-success">📧 Message enregistré et transmis à l'administrateur.</p>
                            <p class="email-dev">🔧 <em>Mode développement : Email simulé (voir contact_emails.log)</em></p>
                        </div>
                    </div>
                <?php endif; ?>
                    
                    <form method="POST" class="contact-form" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="name">Your name</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Your email</label>
                            <input type="email" id="email" name="email" required
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required
                                   value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your message</label>
                            <textarea id="message" name="message" rows="6" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                        </div>
                        
                        <button type="submit" name="send_message" class="send-btn">Send</button>
                    </form>
            </div>
            
            <div class="contact-info">
                <div class="info-card">
                    <h3>📍 My Group</h3>
                    <p>CA 58734, USA</p>
                    <p>📞 +1 555 123 45 67</p>
                    
                    <?php
                    // Afficher l'email de contact de l'admin si disponible
                    try {
                        $stmt_contact = $connect->prepare("SELECT prenom, nom, mail FROM admin WHERE contact = 1 LIMIT 1");
                        $stmt_contact->execute();
                        $contact_admin = $stmt_contact->fetch(PDO::FETCH_ASSOC);
                        
                        if ($contact_admin) {
                            echo '<p>✉️ ' . htmlspecialchars($contact_admin['mail']) . '</p>';
                            echo '<p><small>Contact : ' . htmlspecialchars($contact_admin['prenom'] . ' ' . $contact_admin['nom']) . '</small></p>';
                        }
                    } catch (PDOException $e) {
                        echo '<p>✉️ contact@myband.com</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
        

        

    </main>
    
    <script>
        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (name === '' || email === '' || subject === '' || message === '') {
                alert('Tous les champs sont obligatoires !');
                return false;
            }
            
            // Validation email côté client
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Veuillez entrer une adresse email valide !');
                return false;
            }
            
            return true;
        }
    </script>
    
    <?php require_once 'component/footer.php'; ?>
</body>
</html>
