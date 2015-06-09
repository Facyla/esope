<?php

class AnnotationLikeUnitTest extends ElggCoreUnitTest {
  /**
   * 
   * @var ElggObject 
   */
  protected $object;
  
  public function setUp(){
    $this->object = new ElggObject;
    $this->object->subtype = 'groupforumtopic';
    $this->object->title = 'title';
    $this->object->desc = 'desc';
    $this->object->save();
    
  }
  public function tearDown() {
    $this->object->delete();
  }
  public function test() {
    $user = get_loggedin_user();

    $this->object->annotate('group_topic_post', 'foobar1', ACCESS_PUBLIC, 1, $user->guid);
    $this->object->annotate('group_topic_post', 'foobar2', ACCESS_PUBLIC, 1, $user->guid);
    
    $annotations = get_annotations($this->object->getGUID(), 'object', 'groupforumtopic', 'group_topic_post');
    $annotation = array_shift($annotations);
    
    $al = new AnnotationLike($annotation);
    
    // assert valid
    $this->assertTrue($al->isValid());
    
    // assert 0 count
    $this->assertEqual(0, $al->count());
    
    $al->like($user->guid);

    // assert 1 like
    $this->assertEqual(1, $al->count());

    
    $user2 = new ElggUser();
    $user2->save();
    $al->like($user2->guid);
    // assert 2 like
    $this->assertEqual(2, $al->count());
    
    $al->cancel($user->guid);
    // assert 1 like
    $this->assertEqual(1, $al->count());
    
    $user2->delete();
  }

}