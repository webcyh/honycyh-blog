<?php include HOME.DS.'components'.DS.'header.tpl'?>
<a  href="https://github.com/webcyh" class="git-link hidden-xs"></a>
  <main id="main" class="container">
  	 <div class="row">
	      <div class="col-md-8 col-md-push-1 pjax">
	          <div class="daily" id="dailytest">
		        <?php echo $diary['content']; ?>
		      </div>
	      </div>
	       <?php include HOME.DS.'components'.DS.'aside.tpl'?>
    </div>
 </main>
<?php include HOME.DS.'components'.DS.'footer.tpl'?>
