<?php

namespace Agolomazov\Tools\Url;

/**
 *  Класс для проверки работоспособности удаленной страницы
 *
 * Class Scanner
 * @package Agolomazov\Tools\Url
 */
class Scanner {


	/**
	 * @var array - Массив URL адресов
	 */
	protected $urls;

	/**
	 * @var \GuzzleHttp\Client - объект, который делает запросы на удаленный сервер
	 */
	protected $httpClient;

	/**
	 * Scanner constructor.
	 *
	 * @param array $urls - массив адресов для сканирования
	 */
	public function __construct( array $urls ) {

		$this->urls       = $urls;
		$this->httpClient = new \GuzzleHttp\Client();

	}


	/**
	 * @return array - массив невалидных урлов
	 */
	public function getInvalidUrls() {
		$invalidUrls = [ ];

		foreach ( $this->urls as $url ) {
			try {
				$statusCode = $this->getStatusCodeForUrl( $url );
			} catch ( \Exception $e ) {
				$statusCode = 500;
			}

			if ( $statusCode >= 400 ) {
				array_push( $invalidUrls, array(
					'url'    => $url,
					'status' => $statusCode
				) );
			}
		}

		return $invalidUrls;

	}


	/**
	 *  Возвращает код состояния HTTP для URL-адреса
	 *
	 * @param $url - удаленный URL адрес
	 *
	 * @return mixed - Код состояния HTTP
	 */
	protected function getStatusCodeForUrl( $url ) {
		$httpResponse = $this->httpClient->options( $url );

		return $httpResponse->getStatusCode();
	}
}