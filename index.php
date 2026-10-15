<?php
require_once 'config/db.php';

$profile = null;
$sql = "SELECT * FROM profile LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $profile = mysqli_fetch_assoc($result);
}

$educations = [];
$sql = "SELECT * FROM education ORDER BY start_year DESC";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $educations[] = $row;
    }
}

$skills = [];
if ($profile){
    $profile_id = intval($profile['id']);
    $sql = "SELECT * FROM skill WHERE profile_id = $profile_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)){
            $skills[] = $row;
        }
    }
}

$trainings = [];
if ($profile){
    $profile_id = intval($profile['id']);
    $sql = "SELECT * FROM training WHERE profile_id = $profile_id ORDER BY training_year DESC";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)){
            $trainings[] = $row;
        }
    }
}
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $profile ? htmlspecialchars($profile['full_name']) : 'My Resume'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body>
<div class="container">
    <header class="hero card">
        <img class="avatar" src="assets/images/<?php echo $profile ? htmlspecialchars($profile['photo']) : 'BB.jpg'; ?>?v=3" alt="Profile Photo">
        <div>
            <h1><?php echo $profile ? htmlspecialchars($profile['full_name']) : 'Your Name'; ?></h1>
            <p class="headline"><?php echo $profile ? htmlspecialchars($profile['headline']) : 'Student Resume Website'; ?></p>
            <?php if ($profile): ?>
                <p>📧 <?php echo htmlspecialchars($profile['email']); ?></p>
                <p>📱 <?php echo htmlspecialchars($profile['phone']); ?></p>
                <p>📍 <?php echo htmlspecialchars($profile['address']); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <section class="card">
        <h2>About Me</h2>
        <p><?php echo $profile ? nl2br(htmlspecialchars($profile['about_me'])) : 'Add your profile data in phpMyAdmin.'; ?></p>
    </section>

    <section class="card">
        <h2>Education</h2>
        <?php if (count($educations) > 0): ?>
            <?php foreach ($educations as $edu): ?>
                <div class="item">
                    <h3><?php echo htmlspecialchars($edu['degree']); ?></h3>
                    <p><?php echo htmlspecialchars($edu['institution']); ?></p>
                    <p><?php echo htmlspecialchars($edu['start_year']); ?> - <?php echo htmlspecialchars($edu['end_year']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No education data found.</p>
        <?php endif; ?>
    </section>

    <section class="card">
        <h2>Skills</h2>

<a href="skills.php" style="display:inline-block; background:#d4af37; color:#18121f; padding:10px 18px; border-radius:6px; text-decoration:none; font-weight:bold; margin-bottom:15px;">Manage Skills →</a>
   
        <div class="skills">
            <?php foreach ($skills as $skill): ?>
                <div class="skill-badge">
                    <strong><?php echo htmlspecialchars($skill['skill_name']); ?></strong>
                    <span><?php echo htmlspecialchars($skill['skill_level']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="card">
        <h2>Training / Certificates</h2>
        <?php if (count($trainings) > 0): ?>
            <?php foreach ($trainings as $training): ?>
                <div class="item">
                    <h3><?php echo htmlspecialchars($training['course_name']); ?></h3>
                    <p><?php echo htmlspecialchars($training['organization']); ?>, <?php echo htmlspecialchars($training['training_year']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No training data found.</p>
        <?php endif; ?>
    </section>

    <footer>
        Database Lab: Personal Resume Website with PHP + MySQL
    </footer>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>