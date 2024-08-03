<?php
$title= "Macro School - About";
$meta_description = "$title - macro school Call 880 1563 4668 21";
$meta_keywords = "$title, Macro School, macroschool,macro,schoolmacro,macro";
$header_active = "About";
?>
<?php
include("../../inc/header.php");
?>

<section class="about__achievements">
        <div class="container about__achievemets-container">
            <div class="about__achievements-left">
                 <img src="public/images/about achievements.svg">
            </div>
            <div class="about__achievements-right">
                 <h1>Achievements</h1>
                 <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis quia facere temporibus. Modi, rerum ipsum corrupti vero deserunt odio eveniet magnam deleniti possimus incidunt fugit explicabo nesciunt quaerat aut. Nihil!
                 </p>
                 <div class="achievements__card">
                    <article class="achievement__card">
                        <span class="achievements__icon">
                            <i class="fa-solid fa-video"></i>
                        </span>
                        <h3>450+</h3>
                        <p>Courses</p>
                    </article>


                    <article class="achievement__card">
                        <span class="achievements__icon">
                            <i class="fa-solid fa-users"></i>
                        </span>
                        <h3>1000+</h3>
                        <p>Students</p>
                    </article>

                    
                    <article class="achievement__card">
                        <span class="achievements__icon">
                            <i class="fa-solid fa-award"></i>
                        </span>
                        <h3>50+</h3>
                        <p>Awards</p>
                    </article>
                 </div>
            </div>
        </div>
     </section>




     <section class="team">
          <h2>Meet Our Team</h2>
        <div class="container team__container">
        <?php
                            $Sql = "select * from faculties order by id desc";
                            $Stmt = fetch_data($connection, $Sql);
                            if (mysqli_stmt_num_rows($Stmt) == 0) {
                                $noOrder = "Empty Teacher";
                            } else {
                                mysqli_stmt_bind_result(
                                    $Stmt,
                                    $id,
                                    $name,
                                    $department,
                                    $image,
                                    $link
                                );
                                while (mysqli_stmt_fetch($Stmt)) {?>
            <article class="team__member">
                <div class="team__member-image">
                    <img src="<?=LINK;?>/public/images/<?=$image;?>">
                </div>
                <div class="team__member-info">
                    <h4><?=$name;?></h4>
                    <p><?=$department;?></p>
                </div>
                <div class="team__member-socials">
                    <a href="<?=$link;?>"><i class="fa-brands fa-facebook"></i></a>
                </div>
            </article>
            <?php }}?>

    
            
        </div>
     </section>

<?php
include("../../inc/footer.php");
?>
<script src="<?=LINK;?>main.js"></script>
</body>

</html>