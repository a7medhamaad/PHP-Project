<?php include 'inc/header.php'; ?>
<?php if(!isset($_SESSION['auth'])){
    header("location:login.php");
    die();
} ?>
<?php include 'inc/footer.php'; ?>
<?php include 'inc/nav.php'; ?>


 <div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <h2>Name: <?php echo $_SESSION['auth']['name']; ?> </h2>
            <h2>Email: <?php echo $_SESSION['auth']['email']; ?> </h2>

        </div>
    </div>
 </div>
