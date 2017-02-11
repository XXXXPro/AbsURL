# AbsURL
Simple PHP class for building absolute URL from relative and base.

Usage:

require_once 'AbsURL.php';
$absolue_url = AbsURL::build($relative_url,$base_url);

Example:
print AbsURL::build('all.min.css','http://xpro.su/skins/4xpro/');
will output 
http://xpro.su/skins/4xpro/all.min.css


