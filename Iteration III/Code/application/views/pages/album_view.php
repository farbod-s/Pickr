<?php
  $is_logged_in = $this->tank_auth->is_logged_in(); 
?>
<?php $adress= base_url().'index.php/album/deletepic/'.$picId /$albumId ; ?>">
<div class="container">
<div class = "Album_header">
			<a class="ImgLink" href=""><div class = "avatar">	
				<div class="top_pic">
				
				</div>
			</div></a>
			<div class = "id_info">
				<div id="BoardUsers">
					<span id="BoardUserName" style="line-height: 2"><a href=""><span>User_Name</span></a></span>
				</div>
				<div id="BoardStats">                                  
				<p style="line-height: 6"><span style="font-size: 105%">
				<?php
				$pic_num=0;
					foreach ($data as $key => $value)
					{
						$pic_num++;
					}
					echo ($pic_num);
				?>
				</span><span> Picks</span></p>                 
				</div>
			</div>
			<div class = "album_info">
				<div id="album_title">
				<span>
					<?php  
					$name=$albumname['0'] -> name;
					echo $name;	
    				?>
    			</span>
				</div>
				<div id="buttons">
				<form action="<?php echo base_url().'index.php/album/delete/'.$albumId ?>" method="get">
					<input class="delete" type="submit" value="Delete Album">
				</form>
				<form action="<?php echo base_url().'index.php/album/rename/'.$albumId ?>" method="get">
					<input class="rename" type="submit" value="Rename Album">
					<input name="newname" type="text" />
			</form>
		</div>
		</div>
		</div>
		</div>
	<div id="holder">

    <div class="gallery">
    <?php
    	
        foreach ($data as $var=> $value) {
    		$i=$value->picture_id;
            echo '<div class="article">
                      <div class="frame">
                      <figure class="cap-bot">
                        <div class="inner-box" id="pic_'.$i.'"'; echo 'onMouseOver="ShowActions(this.id)" onMouseOut="HideActions(this.id)"';echo '>
                            ';
                            
                            echo '<span class="tool-box">
                                <a href="#pick" role="button" class="btn btn-small" data-toggle="modal"><i class="icon-magnet"></i></a>
                                <a class="btn btn-small" href="#" action=" <?php echo $adress ?>"><i class="icon-delete"></i></a>
       
                            </span>';
                            echo '<a class="pic-link" href="#">
                                <img id="pic_'.$i.'" class="lazy" src="'.base_url().'resources/images/grey.gif" data-original="'.base_url().'resources/images/main/'.$i.'.jpg" alt="pic_'.$i.'" onLoad="OnImageLoad(event)" />
                            </a>
                              <figcaption>
                              <span>by unknown photographer</span>
                              <span class="record pull-right">
                                  <i class="icon-comment icon-white record-img"></i> '.(2 * $i + 3).'
                                  <i class="icon-heart icon-white record-img"></i> '.(2 * $i + 1).'
                              </span>
                          </figcaption>
                        </div>
                    </figure>
                    </div>
                </div>';
        }
    ?>
    </div>
    <!-- END Load Pictures -->
 </div>
  <button class="btn btn-large btn-block" id="btn-load" type="button"><b>More</b></button>
</div>

<button id="ScrollToTop" class="Button WhiteButton Indicator" type="button" style="display: none;">
  Scroll to Top
</button>