<?php
namespace Box\Tests\Mod\Email\Api;


class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGet_list()
    {
        $clientApi    = new \Box\Mod\Email\Api\Client();
        $emailService = new \Box\Mod\Email\Service();

        $willReturn = array(
            "list"     => array(
                'id' => 1
            ),
        );
        $pager = $this->getMockBuilder('Box_Pagination')->getMock();
        $pager->expects($this->atLeastOnce())
            ->method('getSimpleResultSet')
            ->will($this->returnValue($willReturn));

        $di          = new \Box_Di();
        $di['pager'] = $pager;
        $clientApi->setDi($di);

        $service = $emailService;
        $clientApi->setService($service);

        $client     = new \Model_Client();
        $client->loadBean(new \RedBeanPHP\OODBBean());
        $client->id = rand(1, 100);
        $clientApi->setIdentity($client);

        $result = $clientApi->get_list(array());
        $this->assertInternalType('array', $result);

        $this->assertArrayHasKey('list', $result);
        $this->assertInternalType('array', $result['list']);
    }

    public function testGet()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();


        $model = new \Model_ActivityClientEmail();
        $model->loadBean(new \RedBeanPHP\OODBBean());
        $service = $this->getMockBuilder('Box\Mod\Email\Service')->setMethods(array('findOneForClientById', 'toApiArray'))->getMock();
        $service->expects($this->atLeastOnce())
            ->method('findOneForClientById')
            ->will($this->returnValue($model));
        $service->expects($this->atLeastOnce())
            ->method('toApiArray')
            ->will($this->returnValue(array()));
        $clientApi->setService($service);

        $client     = new \Model_Client();
        $client->loadBean(new \RedBeanPHP\OODBBean());
        $client->id = rand(1, 100);
        $clientApi->setIdentity($client);

        $result = $clientApi->get(array('id' => 1));
        $this->assertInternalType('array', $result);

    }

    /**
     * @expectedException \Box_Exception
     */
    public function testGetIdNotSetException()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();
        $result    = $clientApi->get(array());
        $this->assertInternalType('array', $result);

    }

    /**
     * @expectedException \Box_Exception
     */
    public function testGetNotFoundException()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();

        $service = $this->getMockBuilder('Box\Mod\Email\Service')->setMethods(array('findOneForClientById'))->getMock();
        $service->expects($this->atLeastOnce())
            ->method('findOneForClientById')
            ->will($this->returnValue(false));

        $client     = new \Model_Client();
        $client->loadBean(new \RedBeanPHP\OODBBean());
        $client->id = 5;
        $clientApi->setIdentity($client);

        $clientApi->setService($service);

        $result = $clientApi->get(array('id' => 1));
        $this->assertInternalType('array', $result);

    }

    public function testResend()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();

        $model = new \Model_ActivityClientEmail();
        $model->loadBean(new \RedBeanPHP\OODBBean());

        $service = $this->getMockBuilder('Box\Mod\Email\Service')->setMethods(array('findOneForClientById', 'resend'))->getMock();
        $service->expects($this->atLeastOnce())
            ->method('findOneForClientById')
            ->will($this->returnValue($model));
        $service->expects($this->atLeastOnce())
            ->method('resend')
            ->will($this->returnValue(true));

        $client     = new \Model_Client();
        $client->loadBean(new \RedBeanPHP\OODBBean());
        $client->id = 5;
        $clientApi->setIdentity($client);

        $clientApi->setService($service);

        $result = $clientApi->resend(array('id' => 1));
        $this->assertTrue($result);

    }

    /**
     * @expectedException \Box_Exception
     */
    public function testResendIdNotSetException()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();
        $result    = $clientApi->resend(array());
        $this->assertInternalType('array', $result);

    }

    /**
     * @expectedException \Box_Exception
     */
    public function testResendNotFoundException()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();

        $service = $this->getMockBuilder('Box\Mod\Email\Service')->setMethods(array('findOneForClientById'))->getMock();
        $service->expects($this->atLeastOnce())
            ->method('findOneForClientById')
            ->will($this->returnValue(false));

        $client     = new \Model_Client();
        $client->loadBean(new \RedBeanPHP\OODBBean());
        $client->id = 5;

        $clientApi->setIdentity($client);

        $clientApi->setService($service);

        $result = $clientApi->resend(array('id' => 1));
        $this->assertInternalType('array', $result);

    }

    public function testDelete()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();

        $di = new \Box_Di();

        $model = new \Model_ActivityClientEmail();
        $model->loadBean(new \RedBeanPHP\OODBBean());
        $service = $this->getMockBuilder('Box\Mod\Email\Service')->setMethods(array('findOneForClientById', 'rm'))->getMock();
        $service->expects($this->atLeastOnce())
            ->method('findOneForClientById')
            ->will($this->returnValue($model));
        $service->expects($this->atLeastOnce())
            ->method('rm')
            ->will($this->returnValue(true));

        $client     = new \Model_Client();
        $client->loadBean(new \RedBeanPHP\OODBBean());
        $client->id = 5;
        $clientApi->setIdentity($client);

        $clientApi->setService($service);

        $result = $clientApi->delete(array('id' => 1));
        $this->assertTrue($result);

    }

    /**
     * @expectedException \Box_Exception
     */
    public function testDeleteIdNotSetException()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();
        $result    = $clientApi->delete(array());
        $this->assertInternalType('array', $result);

    }

    /**
     * @expectedException \Box_Exception
     */
    public function testDeleteNotFoundException()
    {
        $clientApi = new \Box\Mod\Email\Api\Client();

        $service = $this->getMockBuilder('Box\Mod\Email\Service')->setMethods(array('findOneForClientById'))->getMock();
        $service->expects($this->atLeastOnce())
            ->method('findOneForClientById')
            ->will($this->returnValue(false));

        $client     = new \Model_Client();
        $client->loadBean(new \RedBeanPHP\OODBBean());
        $client->id = 5;

        $clientApi->setIdentity($client);

        $clientApi->setService($service);

        $result = $clientApi->delete(array('id' => 1));
        $this->assertInternalType('array', $result);

    }


}
