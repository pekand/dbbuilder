<?php
$this->blockStart("body");
?>
<style>

</style>

<script type="text/javascript">
	
</script>


  <div class="container">
    <div class="row">
    <div class="col-md-2">
      <form class="form-horizontal" action='' method="POST">
        <fieldset>
          <div id="legend">
            <legend class="">Login</legend>
          </div>
          <div class="form-group">
            <!-- Username -->
            <label c for="username">Username</label>
            <div class="controls">
              <input type="text" id="username" name="username" placeholder="" class="form-control input-xlarge ">
            </div>
          </div>
          <div class="form-group">
            <!-- Password-->
            <label for="password">Password</label>
            <div class="controls">
              <input type="password" id="password" name="password" placeholder="" class="form-control input-xlarge">
            </div>
          </div>
          <div class="form-group">
            <!-- Submit -->
            <div class="controls">
              <button class="btn btn-success">Login</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>


<?php

$this->blockEnd("body");

$this->extend("layout");