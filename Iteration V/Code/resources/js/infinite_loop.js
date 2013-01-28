var handler = null;
var page = 0;
var isLoading = false;
var finished = false;
var finished_all = false;
var home_page = false;
var album_page = false;
var home_follow_apiURL = PICKR['baseUrl'] + 'home/more_follow_pics';
var home_public_apiURL = PICKR['baseUrl'] + 'home/more_public_pics';
var album_apiURL = PICKR['baseUrl'] + 'album/more_pics';

var search_page = false;
var search_apiURL = PICKR['baseUrl'] + 'search/more_search_results';

// Prepare layout options.
var options = {
	autoResize: true, // This will auto-update the layout when the browser window is resized.
	container: $('#main'), // Optional, used for some extra CSS styling
	offset: 10, // Optional, the distance between grid items
	itemWidth: 222 // Optional, the width of a grid item
};

function isAlbumPage() {
	if(PICKR['uri_segment_1'] && PICKR['uri_segment_2'] && PICKR['uri_segment_3'])
		return true;
};

function isHomePage() {
	if((!PICKR['uri_segment_1'] && !PICKR['uri_segment_2'] && !PICKR['uri_segment_3']) ||
	   (!PICKR['uri_segment_2'] && !PICKR['uri_segment_3']))
		return true;
};

function isSearchPage() {
	if(PICKR['uri_segment_1'] == 'search') {
		return true;
	}
}

/**
* When scrolled all the way to the bottom, add more tiles.
*/
function onScroll(event) {
	if(album_page && finished)		return;
	if(home_page && finished_all)	return;
	if(search_page && finished)     return;
	// Only check when we're not still waiting for data.
	if(!isLoading) {
		// Check if we're within 100 pixels of the bottom edge of the broser window.
		var closeToBottom = ($(window).scrollTop() + $(window).height() > $(document).height() - 100);
		if(closeToBottom) {
			loadData();
		}
	}
};

/**
* Refreshes the layout.
*/
function applyLayout() {
	// Clear our previous layout handler.
	if(handler) handler.wookmarkClear();

	// Create a new layout handler.
	handler = $('#tiles li');
	handler.wookmark(options);
};

/**
* Loads data from the API.
*/
function loadData() {
	isLoading = true;
	$('#loaderCircle').show();
	if(search_page && !finished) {
		$.ajax({
			url: search_apiURL,
			type: 'POST',
			dataType: 'JSON',
			data: {page: page, searchStr: PICKR['uri_segment_3']},
			success: onLoadSearchResults
		});
	}
	else if(home_page && !finished) {
		$.ajax({
			url: home_follow_apiURL,
			type: 'POST',
			dataType: 'JSON',
			data: {page: page}, // Page parameter to make sure we load new data
			success: onLoadFollowData
		});
	}
	else if(home_page && finished) {
		$.ajax({
			url: home_public_apiURL,
			type: 'POST',
			dataType: 'JSON',
			data: {page: page}, // Page parameter to make sure we load new data
			success: onLoadPublicData
		});
	}
	else if(album_page) {
		$.ajax({
			url: album_apiURL,
			type: 'POST',
			dataType: 'JSON',
			data: {page: page, username: PICKR['uri_segment_2'], album_name: PICKR['uri_segment_3']}, // Page parameter to make sure we load new data
			success: onLoadData
		});
	}
};

/**
* Receives data from the API, creates HTML for images and updates the layout
*/
function onLoadData(data) {
	isLoading = false;
	$('#loaderCircle').hide();

	// Increment page index for future calls.
	page++;

	// Create HTML for the images.
	var html = data;

	if(data == '')
		finished = true;

	// Add image HTML to the page.
	$('#tiles').append(html);

	// Apply layout.
	applyLayout();
};

function onLoadFollowData(data) {
	isLoading = false;
	$('#loaderCircle').hide();

	// Increment page index for future calls.
	page++;

	// Create HTML for the images.
	var html = data.html;

	if(html == '') {
		finished = true;
		page = 0;
	}

	// Add image HTML to the page.
	$('#tiles').append(html);

	if(data.state == 'true') {
		finished = true;
		page = 0;
		loadData();
	}

	// Apply layout.
	applyLayout();
};

function onLoadPublicData(data) {
	isLoading = false;
	$('#loaderCircle').hide();

	// Increment page index for future calls.
	page++;

	// Create HTML for the images.
	var html = data;

	if(data == '') {
		finished_all = true;
		$('#finished').show();
	}

	// Add image HTML to the page.
	$('#tiles').append(html);

	// Apply layout.
	applyLayout();
};

function onLoadSearchResults(data) {
	// alert(data);
	isLoading = false;
	$('#loaderCircle').hide();

	// Increment page index for future calls.
	page++;

	// Create HTML for the images.
	var html = data;

	if(html == '') {
		finished = true;
		page = 0;
	}

	// Add image HTML to the page.
	$('#tiles').append(html);

	// Apply layout.
	applyLayout();
}

$(document).ready(new function() {
	// detect where we are
	if(isSearchPage()) {
		search_page = true;
	}
	else if(isHomePage()) {
		home_page = true;
	}
	else if(isAlbumPage()) {
		album_page = true;
	}

	// Capture scroll event.
	$(document).bind('scroll', onScroll);

	// Load first data from the API.
	loadData();
});