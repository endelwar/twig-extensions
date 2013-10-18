<?php

	require_once dirname(__FILE__) . '/../Image/ImageHandler.php';

	class Image_Twig_Extension extends Twig_Extension {

		private $cache_dir;

		public function __construct()
		{
			$this->cache_dir = dirname(__FILE__) . '/../../../cache/images';
		}

		public function getFunctions()
		{
			return array(
				'image' => new \Twig_Function_Method($this, 'image', array('is_safe' => array('html'))),
				'new_image' => new \Twig_Function_Method($this, 'newImage', array('is_safe' => array('html')))
			);
		}

		public function image($path)
		{
			return $this->open($path);
		}

		public function newImage($width, $height)
		{
			return $this->create($width, $height);
		}

		public function getName()
		{
			return 'image';
		}

		/**
		 * Get a manipulable image instance
		 *
		 * @param string $file the image path
		 *
		 * @return object a manipulable image instance
		 */
		private function open($file)
		{
			return $this->createInstance($file);
		}

		/**
		 * Get a new image
		 *
		 * @param $w the width
		 * @param $h the height
		 *
		 * @return object a manipulable image instance
		 */
		private function create($w, $h)
		{
			return $this->createInstance(null, $w, $h);
		}

		/**
		 * Creates an instance defining the cache directory
		 */
		private function createInstance($file, $w = null, $h = null)
		{
			//$asset = $this->container->get('templating.helper.assets');
			//$full_file_path = '../../..' . $file;
			$full_file_path = substr($file, 1);
			//echo $full_file_path;


			$image = new ImageHandler($full_file_path, $w, $h);

			$image->setCacheDir($this->cache_dir);

			$image->setFileCallback(function($full_file_path)
					{
						$site_path = dirname($_SERVER['SCRIPT_FILENAME']);
						$relative_file_path = str_replace($site_path, '', $full_file_path);
						$relative_file_path = str_replace('/vendor/endelwar/TwigExtension/../../..', '', $relative_file_path);
						return $relative_file_path;
					});

			return $image;
		}

	}
