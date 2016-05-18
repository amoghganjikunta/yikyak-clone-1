<?php
	// some error reporting stuff
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	
	// get the header and navbar in here
	require_once('includes/head.php');
	require_once('includes/header.php');

	try {
		$posts = DB::query("SELECT * FROM posts ORDER BY timestamp DESC;");
	} catch (MeekroDBException $e){
		header('Location: /index.php?noposts');
	}

?>


<div class="splash">
	<div class="splash-inner">
		<a href="#mission"><h1>Save the Rocks</h1></a>
	</div>
</div>

<div class="container">
	<div class="content-wrapper">
		<div id="mission" class="mission">
			<h2>Our Mission</h2>
			<p>We are a society dedicated to saving the rocks. Each day, thousands of rocks are blasted into oblivion by anthropogenic activities. If we don't act soon, there will be no more rocks left.</p>
			<p>We have been active for over 3 years and embrace every chance we get to save these majestic accumulations of minerals and sediment. This site is a means for you to share your rock saving activity with other rock lovers. Please sign up and tell us a bit about the last rock you saved.</p>
		</div>
		<div id="posts" class="posts-wrapper">
			<h2>Recent Posts</h2>
			<h1 id="add-post"><i class="fa fa-plus" aria-hidden="true"></i></h1>
			<div id="new-post-wrapper">
				<?php if(isset($_SESSION['username'])): ?>
					<form action="post_process.php" method="post">
						<div class="form-group">
							<textarea id="post-text" class="form-control" name="body" placeholder="Type your post here"></textarea>
						</div>
						<button type="submit" class="btn btn-default">Post</button>
					</form>
				<?php else: ?>
					<h4>You must be logged in to make a new post.</h4>
				<?php endif; ?>
			</div>

			<?php foreach($posts as $post): ?>
				<div class="post">
					<div class="row">
						<div class="col-sm-11">
							<h4><?php print $post['body']; ?></h4>
							<p>Posted:
							<?php
								date_default_timezone_set('America/New_York');
								$timestamp_as_unix = strtotime($post['timestamp']);
								print date('F j, Y g:i a', $timestamp_as_unix);
							?>
								by <?php print $post['username']; ?>		
							</p>
						</div>
						<div class="col-sm-1 votes-wrapper">
							<a href="vote.php?vote=upvote&id=<?php print $post['id']; ?>&user=<?php print $_SESSION['username']; ?>" class="votes"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
							<div class="votes"><?php print $post['votes']; ?></div>
							<a href="vote.php?vote=downvote&id=<?php print $post['id']; ?>&user=<?php print $_SESSION['username']; ?>" class="votes"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#add-post').click(function(){
		$('#new-post-wrapper').toggle();
	});
});
</script>

<?php require_once('includes/footer.php'); ?>
