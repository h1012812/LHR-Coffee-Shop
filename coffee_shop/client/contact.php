<?php include 'inclueds/client_header.php'; ?>
<?php include __DIR__ . '/../config.php'; ?>
<?php
include '../includes/db.php';
?>

<?php
$success = "";
$error   = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");

    if($stmt->execute([$name, $email, $message])){
        $success = "Your message has been sent!";
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>

    <section class="contact-page">
        <div class="section-title">
            <h2>Contact Us</h2>
            <p>We'd love to hear from you</p>
        </div>

        <div class="contact-form-wrapper">

            <?php if($success): ?>
                <p class="form-success"><?php echo $success; ?></p>
            <?php endif; ?>

            <?php if($error): ?>
                <p class="form-error"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" name="name" placeholder="John Doe" required>
                </div>

                <div class="form-group">
                    <label>Your Email</label>
                    <input type="email" name="email" placeholder="example@gmail.com" required>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="6" placeholder="Write your message..." required></textarea>
                </div>

                <button type="submit" class="btn">Send Message</button>

            </form>
        </div>
    </section>

<?php include 'inclueds/client_footer.php'; ?>

