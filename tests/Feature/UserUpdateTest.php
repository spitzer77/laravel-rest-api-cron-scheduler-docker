<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */


    public function test_correctness_of_data_synchronization(): void
    {
        $url = "https://jsonplaceholder.typicode.com/users";
        $content = file_get_contents($url);

        $this->assertJson($content);

        $data = json_decode($content, true);
        $this->assertIsArray($data);

        foreach ($data as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('username', $item);
            $this->assertArrayHasKey('email', $item);
            $this->assertArrayHasKey('address', $item);
            $this->assertArrayHasKey('phone', $item);
            $this->assertArrayHasKey('website', $item);
            $this->assertArrayHasKey('company', $item);

            $this->assertIsInt($item['id']);
            $this->assertIsString($item['name']);
            $this->assertIsString($item['username']);
            $this->assertIsString($item['email']);
            $this->assertIsString($item['phone']);
            $this->assertIsString($item['website']);
            $this->assertIsArray($item['company']);

                $address = $item['address'];
                $this->assertIsArray($address);

                $this->assertArrayHasKey('street', $address);
                $this->assertArrayHasKey('suite', $address);
                $this->assertArrayHasKey('city', $address);
                $this->assertArrayHasKey('zipcode', $address);
                $this->assertArrayHasKey('geo', $address);

                $this->assertIsString($address['street']);
                $this->assertIsString($address['suite']);
                $this->assertIsString($address['city']);
                $this->assertIsString($address['zipcode']);

                $geo = $address['geo'];
                $this->assertIsArray($geo);

                    $this->assertArrayHasKey('lat', $geo);
                    $this->assertArrayHasKey('lng', $geo);

                    $this->assertIsString($geo['lat']);
                    $this->assertIsString($geo['lng']);

            $this->assertArrayHasKey('company', $item);
            $company = $item['company'];

                $this->assertArrayHasKey('name', $company);
                $this->assertArrayHasKey('catchPhrase', $company);
                $this->assertArrayHasKey('bs', $company);

                $this->assertIsString($company['name']);
                $this->assertIsString($company['catchPhrase']);
                $this->assertIsString($company['bs']);
        }
    }
}
