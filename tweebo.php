<?php
/*
Plugin Name: Tweebo
Plugin URI: http://wangling.me/
Description: Add Twitter/Weibo buttons to the bottom of each post.
Version: 1.0
Author: Ling Wang
Author URI: http://wangling.me/
License: GPL2
*/


/*
	avoid a name collision, make sure this function is not
	already defined */

if( !function_exists("tweebo")){
	function tweebo($content){

	/*	we want to change `the_content` of posts, not pages */

		if(!is_page( )){
			$permalink = urlencode(get_permalink());
			$text = the_title('', '', false);
			global $post;
			$excerpt = $post->post_excerpt;
			if (!empty($excerpt)) {
				$text = $text . ': ' . $excerpt;
			}
			
			$twitter_script = <<<EOT
<a href="http://twitter.com/share?url=$permalink" class="twitter-share-button" data-url="$permalink" data-text="$text" data-count="none" data-via="an0">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
EOT;
			
			$weibo_script = <<<EOT
<script type="text/javascript" charset="utf-8">
(function(){
  var _w = 86 , _h = 18;
  var param = {
    url:"$permalink",
    type:'6',
    count:'', /**是否显示分享数，1显示(可选)*/
    appkey:'', /**您申请的应用appkey,显示分享来源(可选)*/
    title:'$text', /**分享的文字内容(可选，默认为所在页面的title)*/
    pic:'', /**分享图片的路径(可选)*/
    ralateUid:'1676354212', /**关联用户的UID，分享微博会@该用户(可选)*/
    rnd:new Date().valueOf()
  }
  var temp = [];
  for( var p in param ){
    temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
  }
  document.write('<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'" style="margin-left:5px;"></iframe>')
})()
</script>
EOT;

		/*	append the script to the end of `the_content` */
			return $content . '<div class="social">' . $twitter_script . $weibo_script . '</div>';
		} else{

		/*	if `the_content` belongs to a page the result of this filter is no change to `the_content` */

			return $content;
		}
	}

	/*	add our filter function to the hook */

	add_filter('the_content', 'tweebo', 99);
}

?>