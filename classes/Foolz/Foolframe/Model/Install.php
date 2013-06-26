<?php

namespace Foolz\Foolframe\Model;

use \Foolz\Config\Config;
use \Foolz\Foolframe\Model\DoctrineConnection as DC;
use \Foolz\Foolframe\Model\System as System;

class Install
{
	public static function check_database($array)
	{
		switch ($array['type'])
		{
			case 'pdo_mysql':
				try
				{
					new \PDO(
						'mysql:dbname='.$array['database'].';host='.$array['hostname'],
						$array['username'],
						$array['password']
					);

					return true;
				}
				catch (\PDOException $e)
				{
					return false;
				}
			case 'pdo_pgsql':
				try
				{
					new \PDO(
						'pgsql:dbname='.$array['database'].';host='.$array['hostname'],
						$array['username'],
						$array['password']
					);

					return true;
				}
				catch (\PDOException $e)
				{
					return false;
				}
		}
	}


	public static function setup_database($array)
	{
		Config::set('foolz/foolframe', 'db', 'default', array(
			'driver' => $array['type'],
			'host' => $array['hostname'],
			'port' => '3306',
			'dbname' => $array['database'],
			'user' => $array['username'],
			'password' => $array['password'],
			'prefix' => $array['prefix'],
			'charset' => 'utf8mb4',
		));

		Config::save('foolz/foolframe', 'db');
	}

	public static function create_salts()
	{
		// config without slash is the custom foolz one, otherwise it's the fuelphp one
		Config::set('foolz/foolframe', 'config', 'config.cookie_prefix', 'foolframe_'.\Str::random('alnum', 3).'_');
		Config::save('foolz/foolframe', 'config');

		// once we change hashes, the users table is useless
		DC::qb()
			->delete(DC::p('users'))
			->execute();

		Config::set('foolz/foolframe', 'foolauth', 'salt', \Str::random('alnum', 24));
		Config::set('foolz/foolframe', 'foolauth', 'login_hash_salt', \Str::random('alnum', 24));
		Config::save('foolz/foolframe', 'foolauth');

		Config::set('foolz/foolframe', 'cache', 'prefix', 'foolframe_'.\Str::random('alnum', 3).'_');
		Config::save('foolz/foolframe', 'cache');

		$crypt = [];

		foreach(['crypto_key', 'crypto_iv', 'crypto_hmac'] as $key)
		{
			$crypto = '';
			for ($i = 0; $i < 8; $i++)
			{
				$crypto .= static::safe_b64encode(pack('n', mt_rand(0, 0xFFFF)));
			}

			$crypt[$key] = $crypto;
		}

		\Config::set('crypt', $crypt);
		\Config::save(\Fuel::$env.DS.'crypt', 'crypt');
	}


	private static function safe_b64encode($value)
	{
		$data = base64_encode($value);
		$data = str_replace(array('+','/','='), array('-','_',''), $data);
		return $data;
	}


	public static function modules()
	{
		$modules = array(
			'foolfuuka' => array(
				'title' => 'FoolFuuka Imageboard',
				'description' => __('FoolFuuka is one of the most advanced imageboard software written.'),
				'disabled' => false,
			),

			'foolslide' => array(
				'title' => 'FoolSlide Online Reader',
				'description' => __('FoolSlide provides a clean visual interface to view multiple images in reading format. It can be used standalone to offer users the best reading experience available online.'),
				'disabled' => true,
			),

			'foolstatus' => array(
				'title' => __('FoolStatus'),
				'description' => __('FoolStatus is an open-source status dashboard that allows content providers to alert users of network interruptions.'),
				'disabled' => false
			)
		);

		return $modules;
	}
}