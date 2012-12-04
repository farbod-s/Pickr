<?php
// $is_logged_in = $this->tank_auth->is_logged_in();
$uploaded_pic_address = ''; // get uploaded_pic_address


// if($is_logged_in) {
echo '<!-- upload form -->
<div id="upload-picture-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="upload-picture-label" aria-hidden="true">
    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="upload-picture-label">Upload Picture</h3>
    </div>

    <div class="modal-body">
        <img class="media-object pull-left" id="uploaded-image-tumbnail" style="margin-right: 5px;  width: 45%; height: 175px;" src="'; if($uploaded_pic_address != '') echo $pic_address; else echo base_url(IMAGES.'upload_picture.png'); echo '">
        <div class="control-group pull-right" style="width: 50%; margin-bottom: 0;">
            <!-- <div class="controll-group" id="upload-type-btns" style="width: 100%; height: 33px; margin-bottom: 10px;">
                <button class="btn pull-left" id="local-upload" style="width: 49%; height=100%;"><i class="icon-hdd"></i> Local</button>
                <button class="btn pull-right" id="link-upload" style="width: 49%; height=100%;"><i class="icon-globe"></i> Link</button>
            </div> -->

            <!-- <div class="controll-group" id="local-upload-btn" style="width: 100%; height: 33px; margin-bottom: 10px;">
                <span class="btn btn-success fileinput-button">
                    <span><i class="icon-plus icon-white"></i> Add Image</span>
                    <input type="file" name="userfile" multiple>
                </span>
            </div> -->

            <input type="file" name="userfile" multiple style="width: 100%;">

            <div class="btn-group">
              <button style="width: 100%; height: 33px;" id="current-album-upload" class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <strong style="float: left;">Select Album</strong>
                <span class="caret" style="float: right;"></span>
              </button>
              <ul id="album_list-upload" class="dropdown-menu" style="width: 100%; max-height: 145px; overflow-x: hidden; overflow-y: auto;">
                <!-- dropdown menu links -->';
                if($albums) {
                  foreach ($albums as $album) {
                    echo '<li><a href="#" onClick="SetCurrentAlbum(this.innerHTML)">'.$album.'</a></li>';
                  }
                }
                echo '<li class="divider"></li>
                <li>
                  <form action="http://localhost/www/codeigniter/index.php/home/create_album" method="post" id="create-album-form-upload">
                    <input type="text" id="album-name-upload" class="input-small pull-left" style="width: 64%; margin: 0 3% 3% 3%;" placeholder="Album Name" spellcheck="false" />
                    <button type="submit" class="btn pull-right" id="create-album-btn-upload"><strong>Create</strong></button>
                  </form>
                </li>
              </ul>
            </div>';
            $attributes = array('id' => 'upload-form', 'class' => 'form-horizontal');
            echo form_open('index.php/Upload/upload_pic', $attributes);
            echo '<textarea id="album-description-upload" rows="3" cols="40" style="resize: none; margin-top: 10%; width: 96.5%;" maxlength="50" placeholder="Description" onfocus="ShowDescriptionMessage()" onBlur="HideDescriptionMessage()" spellcheck="false"></textarea>
            <input type="submit" class="btn btn-large btn-primary disabled" data-loading-text="Picking..." id="add-to-album-btn-upload" style="width:100%; margin-top:5%; font-weight: bold;" value="Add Picture to Album" disabled="disabled" />
            ';
            echo form_close();
            echo '

        </div>
    </div>
    
    <div class="modal-footer"> 
    </div>
</div>';
// }
?>
