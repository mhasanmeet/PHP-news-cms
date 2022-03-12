<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- post-container -->
                    <div class="post-container">
                        <?php
                            include "config.php";

                            // Pagination code Start here // Part --2
                            $limit = 3;

                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }
                            else{
                                $page = 1;
                            }

                            $offset = ($page - 1) * $limit;
                            // Pagination code end here // Part --2

                            $sql_query = "SELECT post.post_id, post.title, post.description, post.post_date,
                            category.category_name, user.username, post.category, post.post_img FROM post 
                            LEFT JOIN category ON post.category = category.category_id 
                            LEFT JOIN user ON post.author = user.user_id
                            ORDER BY post.post_id
                            DESC LIMIT {$offset}, {$limit}"; 

                            $result = mysqli_query($conn, $sql_query) or die("Connection failed");
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img src="admin/upload/<?php echo $row['post_img']; ?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php'><?php echo $row['category_name']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php'><?php echo $row['username']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                <?php echo $row['post_date']; ?>
                                            </span>
                                        </div>
                                        <p class="description">
                                        <?php echo substr($row['description'],0,230) . "......"; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                                }
                            }
                        ?>

                        <!-- Pagination code Start here // Part --1 -->
                        <?php 
                            $sql_post = "SELECT * FROM post";
                            $sql_post_query = mysqli_query($conn, $sql_post) or die ("Query Failed");

                            if(mysqli_num_rows($sql_post_query) > 0){
                                $total_records =  mysqli_num_rows($sql_post_query);
                                $total_pages = ceil($total_records / $limit);

                                echo '<ul class="pagination admin-pagination">';

                                if($page > 1){
                                    echo '<li><a href="index.php?page='.($page-1).'">Prev</a></li>';
                                }

                                for($i = 1; $i<=$total_pages; $i++){

                                    //Active page code here
                                    if($i == $page){
                                        $active = "active";
                                    }
                                    else{
                                        $active = "";
                                    }
                                    echo '<li class="'. $active .'"><a href="index.php?page='.$i.'">'.$i.'</a></li>'; 
                                }

                                if($total_pages > $page){
                                    echo '<li><a href="index.php?page='.($page+1).'">Next</a></li>';
                                }

                                echo "</ul>";
                            }
                        ?>
                        <!-- Pagination code end here // Part --1 -->
                    </div><!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
