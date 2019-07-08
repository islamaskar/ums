<?php
namespace Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class GroupControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function __construct()
    {
      parent::__construct();
      // Load Fixtures before testing
      $this->loadFixtures([
        'App\DataFixtures\UserFixtures',
        'App\DataFixtures\GroupFixtures',
      ]);    
    }
    
    public function testGroupsListing()
    {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/admin/group/');
        $this->isSuccessful($client->getResponse());
    }

    public function testGroupListingContainsThreeGroups()
    {
      $client = $this->makeClient();
      $crawler = $client->request('GET', '/admin/group/');
      $this->assertRegExp('/Group [1-3]/', $client->getResponse()->getContent());
    }

    public function testGroupShowingLink()
    {
      $client = $this->makeClient();
      $crawler = $client->request('GET', '/admin/group/');
      $a = $crawler->filter('a[alt="show"]')->link();
      $client->click($a);
      $this->isSuccessful($client->getResponse());
      $this->assertContains('Users', $client->getResponse()->getContent());
    }

    public function testGroupAddingForm()
    {
      $client = $this->makeClient();
      $crawler = $client->request('GET', '/admin/group/');
      $client->clickLink('Create new');
      $this->isSuccessful($client->getResponse());
      $this->assertContains('Create Group', $client->getResponse()->getContent());

      //Fill & submit the form
      $client->submitForm('Save', ['group[name]' => 'New Group']);
      $this->assertTrue($client->getResponse()->isRedirect());
      $client->followRedirect();
      $this->assertContains('Group created successfully!', $client->getResponse()->getContent());
    }

    public function testGroupEditingForm()
    {
      $client = $this->makeClient();
      $crawler = $client->request('GET', '/admin/group/');
      $a = $crawler->filter('a[alt="edit"]')->link();
      $client->click($a);
      $this->isSuccessful($client->getResponse());
      $this->assertContains('Edit Group', $client->getResponse()->getContent());

      //Fill & submit the form
      $client->submitForm('Update', ['group[name]' => 'edited Group 1']);
      $this->assertTrue($client->getResponse()->isRedirect());
      $client->followRedirect();
      $this->assertContains('Group updated successfully!', $client->getResponse()->getContent());
    }

    public function testEmptyGroupDeleting()
    {
      $client = $this->makeClient();
      $crawler = $client->request('GET', '/admin/group/');
      $group_ids_arr = $crawler->filter('a[alt^="group_"]')->extract(['alt']);
      $last_group_id = explode("_", array_pop($group_ids_arr));
      $form = $crawler->filter('form[action="/admin/group/'.$last_group_id[1].'"]')->form();
      $client->submit($form);
      
      $client->followRedirect();
      $this->assertContains('Group deleted successfully!', $client->getResponse()->getContent());
    }

    public function testfilledGroupDeleting()
    {
      $client = $this->makeClient();
      $crawler = $client->request('GET', '/admin/group/');
      $group_ids_arr = $crawler->filter('a[alt^="group_"]')->extract(['alt']);
      $last_group_id = explode("_", array_shift($group_ids_arr));
      $form = $crawler->filter('form[action="/admin/group/'.$last_group_id[1].'"]')->form();
      $client->submit($form);
      
      $client->followRedirect();
      $this->assertContains('Sorry, this group is not empty!', $client->getResponse()->getContent());
    }
}