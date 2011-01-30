<?
require_once '/var/www_libs/aws-sdk-for-php/sdk.class.php';
require_once '../php/pear/Flickr/API.php';
require_once '../php/config.inc';

#
# Instantiate Flickr_API
$api =& new Flickr_API($config);

#
# Set up simple db instance
#

$sdb = new AmazonSDB();

#
# Scrape Flickr About
#

$ch = curl_init('http://www.flickr.com/about'); 

// Execute 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$out = curl_exec($ch);

preg_match_all("/\d*@N\d\d/",$out,$match);

$nsid_array = $match[0];

$response   = $sdb->select('SELECT * FROM `prod_drunkpukingpandas`');

echo '<h1>Checking flickr about page for new flickrinos</h1>';

echo '<h2>'.count($nsid_array).' nsids found</h2>';

if($match) {
	$nsids_to_add = array();
	
	for($i=0;count($nsid_array)>$i;$i++) {
		if($nsid_array[$i]) {
			$match_found     = 0;
			$about_page_nsid = $nsid_array[$i];
			foreach($response->body->SelectResult->Item->Attribute as $key => $value) {
				$existing_nsid   = (string) $value->Name;
				
				if($existing_nsid === $about_page_nsid) {
					$match_found = 1;
				}
			}
			
			$flickrino = $api->callMethod('flickr.people.getInfo', array(
				'user_id' => $about_page_nsid
			));
			
			$flickrino_name = $flickrino->children[1]->children[1]->content;
			
			if(!$match_found) {
				echo '<div style="background-color:green;padding:3px;color:white;margin:1px;font-weight:bold;">' . $i . ') I will add ' . $flickrino_name . ' (' . $about_page_nsid . ')</div>';
				$nsids_to_add[$about_page_nsid] = 1;
			} else {
				echo '<div style="background-color:red;padding:3px;color:white;margin:1px;font-weight:bold;">' . $i . ') I will not add ' . $flickrino_name . ' (' . $about_page_nsid . ') because they are already added</div>';
			}
			echo '<br>';
		
		}
	}
	
	echo '<h2>Writing '.count($nsids_to_add).' new folks to the db...</h2>';
	$sdb->put_attributes('prod_drunkpukingpandas','blessed',$nsids_to_add);
	echo '<div>Done.</div>';
} else {
	echo 'oops';	
}
?>