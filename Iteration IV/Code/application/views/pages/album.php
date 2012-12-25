<div class="container">
	<?php
		$description = "";
		$album_name = "";
		$picks = count($pictures);

		if($album_info) {
			$album_name = $album_info[0]['name'];
			$description = $album_info[0]['description'];
		}

		//echo $description;
		//echo $album_name;
		//echo $picks;
		//echo $ME;
		//echo $username;
	?>

	<div class="profile-details">
		
	</div>

	<!-- <hr class="soft" /> -->
	<div id="TitlePro">
        <h1>
            <span>Picks</span>
        </h1>
    </div>

	<!-- Load Pictures -->
    <div class="gallery" style="border-top: 1px solid #BFBFBF; padding-top: 5%;">
    <?php
	if($pictures) {
	$i = 0;
      foreach($pictures as $picture_path) { $i++; ?>
        <div class="article">
              <div class="frame">
                <figure class="cap-bot">
                  <div class="inner-box" id="albumPic_<?php echo $i; ?>">
                      <span class="tool-box">
                          <a href="#rePick" role="button" class="btn btn-small rePick-btn" data-toggle="modal"><i class="icon-magnet"></i></a>
                          <a class="btn btn-small delete-btn" href="#"><i class="icon-trash"></i></a>
                      </span>
                      <a class="pic-link" href="#">
                          <img id="albumPic_<?php echo $i; ?>" class="lazy" src="<?php echo base_url(IMAGES.'grey.gif');?>" data-original="<?php echo $picture_path; ?>" alt="albumPic_<?php echo $i; ?>" />
                      </a>
                      <figcaption>
                        <span>by unknown photographer</span>
                        <span class="record pull-right">
                            <i class="icon-comment icon-white record-img"></i> <span class="record-comment"><?php echo (2 * $i + 3); ?></span>
                            <i class="icon-heart icon-white record-img"></i> <span class="record-like"><?php echo (2 * $i + 1); ?></span>
                        </span>
                      </figcaption>
                  </div>
              </figure>
            </div>
        </div>
    <?php } } ?>
    </div>
    <!-- END Load Pictures -->
</div>