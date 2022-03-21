<?php 
    include "header.php"; 

    if($_SESSION["user_role"] ==  '0'){
        header("Location: post.php");
    }
    
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <?php
                    include "config.php";
                    $cat_id = $_GET['id'];
                    $fetch_cat = "SELECT * FROM category WHERE category_id = {$cat_id}";
                    $result = mysqli_query($conn, $fetch_cat) or die("Connection failed");

                    if (mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                  ?>
                  <form action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id']; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']; ?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="sumbit" class="btn btn-primary" value="Update" required />
                  </form>
                  <?php
                            }
                        }
                  ?>
                
                <?php
                if(isset($_POST['submit'])){
                        include "config.php";

                        $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
                        $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);

                        $select_sql = "SELECT category_name FROM category WHERE category_name = {'$cat_name'} AND NOT category_id = '{$cat_id}'";
                        $update_query = mysqli_query($conn, $select_sql);
                        if(mysqli_num_rows($update_sql)>0){
                            echo "<p style='color:red;text-align:center;margin:10px 0;'>Category Name: '".$category_name."' already exist</P>";
                        }

                    }
                ?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
