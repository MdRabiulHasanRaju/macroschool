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