<?php

require('AbsURL.php');

class AbsURLTest extends PHPUnit_Framework_TestCase {
    /**
    * @dataProvider providerBuild
    */
   public function testBuild($rel,$base,$result) {
     $this->assertEquals(AbsURL::build($rel,$base),$result);
   }

   public function providerBuild() {
      return array(
        array('styles/all.css','http://xpro.su','http://xpro.su/styles/all.css'),
        array('styles/all.css','http://xpro.su/super/index.htm','http://xpro.su/super/styles/all.css'),
        array('#test','http://xpro.su','http://xpro.su/#test'),
        array('#test','http://xpro.su?test=1','http://xpro.su/?test=1#test'),
        array('?test=2','http://xpro.su?test=1#test','http://xpro.su/?test=2'),
        array('http://ya.ru','http://xpro.su?test=1#test','http://ya.ru'),
        array('http://ya.ru/test/test1.htm','http://xpro.su?test=1#test','http://ya.ru/test/test1.htm'),
        array('styles/all.css','http://xpro.su?test=1#test','http://xpro.su/styles/all.css'),
        array('','http://xpro.su?test=1#test','http://xpro.su/?test=1#test'),
        array('/','http://xpro.su?test=1#test','http://xpro.su/'),
        array('/','http://xpro.su:83?test=1#test','http://xpro.su:83/')
      );
   }
}
