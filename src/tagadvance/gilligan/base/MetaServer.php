<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\net\IPv4Address;

/**
 * The sole purpose of this class is to aid my IDE's code assist.
 * Most of the documentation was shamelessly coped from {@link http://php.net/manual/en/reserved.variables.server.php $_SERVER} (with minor changes).
 *
 * @author Tag Spilman <tagadvance+gilligan@gmail.com>
 * @see http://php.net/manual/en/reserved.variables.server.php
 */
class MetaServer {

	private $server;
	
	// FIXME: many variables are not set in CLI
	static function create() {
		return new self ( $_SERVER );
	}

	function __construct(array $server) {
		$this->server = $server;
	}

	/**
	 * The filename of the currently executing script, relative to the document
	 * root.
	 * For instance, <code>$_SERVER['PHP_SELF']</code> in a script at the
	 * address <code>http://example.com/foo/bar.php</code> would be
	 * <code>/foo/bar.php</code>. The <a
	 * href="http://www.php.net/manual/en/language.constants.predefined.php">__FILE__</a>
	 * constant contains the full path and filename of the current (i.e.
	 * included) file. If PHP is running as a command-line processor this
	 * variable contains the script name since PHP 4.3.0. Previously it was not
	 * available.
	 */
	function phpSelf() {
		return $this->server ['PHP_SELF'];
	}

	/**
	 * Array of arguments passed to the script.
	 * When the script is run on the command line, this gives C-style access to
	 * the command line parameters. When called via the GET method, this will
	 * contain the query string.
	 * <strong>Note:</strong> The first argument <code>$argv[0]</code> is always
	 * the name that was used to run the script (if run on the command line).
	 *
	 * @return array
	 */
	function args() {
		$register_argc_argv = ini_get ( 'register_argc_argv' );
		if (! $register_argc_argv) {
			$message = 'This variable is not available when register_argc_argv is disabled.';
			trigger_error ( $message, E_USER_ERROR );
		}
		return $this->server ['argv'];
	}

	/**
	 *
	 * @return integer the number of command line parameters passed to the
	 *         script (if run on the command line).
	 */
	function argCount() {
		return $this->server ['argc'];
	}

	/**
	 *
	 * @return string What revision of the CGI specification the server is
	 *         using; i.e. <code>'CGI/1.1</code>'.
	 */
	function gatewayInterface() {
		return $this->server ['GATEWAY_INTERFACE'];
	}

	/**
	 *
	 * @return string The IP address of the server under which the current
	 *         script is executing.
	 */
	function address() {
		return isset ( $this->server ['SERVER_ADDR'] ) ? $this->server ['SERVER_ADDR'] : IPv4Address::LOCALHOST;
	}

	/**
	 *
	 * @return string The name of the server host under which the current script
	 *         is executing. If the script is running on a virtual host, this
	 *         will be the value defined for that virtual host.
	 */
	function name() {
		return $this->server ['SERVER_NAME'];
	}

	/**
	 *
	 * @return string Server identification string, given in the headers when
	 *         responding to requests.
	 */
	function software() {
		return $this->server ['SERVER_SOFTWARE'];
	}

	/**
	 *
	 * @return string Name and revision of the information protocol via which
	 *         the page was requested; i.e. <code>'HTTP/1.0</code>';
	 */
	function protocol() {
		return $this->server ['SERVER_PROTOCOL'];
	}

	/**
	 * <strong>Note:</strong> PHP script is terminated after sending headers (it
	 * means after producing any output without output buffering) if the request
	 * method was HEAD.
	 *
	 * @return string Which request method was used to access the page; i.e.
	 *         <code>'GET</code>', <code>'HEAD</code>', <code>'POST</code>',
	 *         <code>'PUT</code>'.
	 */
	function requestMethod() {
		return $this->server ['REQUEST_METHOD'];
	}

	/**
	 *
	 * @return integer The timestamp of the start of the request. Available
	 *         since PHP 5.1.0.
	 */
	function requestTime() {
		return $this->server ['REQUEST_TIME'];
	}

	/**
	 *
	 * @return float The timestamp of the start of the request, with microsecond
	 *         precision. Available since PHP 5.4.0.
	 */
	function requestTimeFloat() {
		return $this->server ['REQUEST_TIME_FLOAT'];
	}

	/**
	 *
	 * @return string The query string, if any, via which the page was accessed.
	 */
	function queryString() {
		return $this->server ['QUERY_STRING'];
	}

	/**
	 *
	 * @return string The document root directory under which the current script
	 *         is executing, as defined in the server's configuration file.
	 */
	function documentRoot() {
		return $this->server ['DOCUMENT_ROOT'];
	}

	/**
	 *
	 * @return string Contents of the <code>Accept:</code> header from the
	 *         current request, if there is one.
	 */
	function httpAccept() {
		return $this->server ['HTTP_ACCEPT'];
	}

	/**
	 *
	 * @return string Contents of the <code>Accept-Charset:</code> header from
	 *         the current request, if there is one. e.g.
	 *         <code>'iso-8859-1,*,utf-8</code>'.
	 */
	function httpAcceptCharset() {
		return $this->server ['HTTP_ACCEPT_CHARSET'];
	}

	/**
	 *
	 * @return string Contents of the <code>Accept-Encoding:</code> header from
	 *         the current request, if there is one. e.g. <code>'gzip</code>'.
	 */
	function httpAcceptCoding() {
		return $this->server ['HTTP_ACCEPT_ENCODING'];
	}

	/**
	 *
	 * @return string Contents of the <code>Accept-Language:</code> header from
	 *         the current request, if there is one. e.g. <code>'en</code>'.
	 */
	function httpAcceptLanguage() {
		return $this->server ['HTTP_ACCEPT_LANGUAGE'];
	}

	/**
	 *
	 * @return string Contents of the <code>Connection:<code> header from the
	 *         current request, if there is one. e.g. <code>'Keep-Alive</code>'.
	 */
	function httpConnection() {
		return $this->server ['HTTP_CONNECTION'];
	}

	/**
	 *
	 * @return string Contents of the <code>Host:</code> header from the current
	 *         request, if there is one.
	 */
	function httpHost() {
		return $this->server ['HTTP_HOST'];
	}

	/**
	 *
	 * @return string The address of the page (if any) which referred the user
	 *         agent to the current page. This is set by the user agent. Not all
	 *         user agents will set this, and some provide the ability to modify
	 *         <code>HTTP_REFERER</code> as a feature. In short, it cannot
	 *         really be trusted.
	 */
	function httpReferer() {
		return $this->server ['HTTP_REFERER'];
	}

	/**
	 *
	 * @return string Contents of the <code>User-Agent:</code> header from the
	 *         current request, if there is one. This is a string denoting the
	 *         user agent being which is accessing the page. A typical example
	 *         is: Mozilla/4.5 [en] (X11; U; Linux 2.2.9 i586). Among other
	 *         things, you can use this value with <a
	 *        
	 *        
	 *         href="http://www.php.net/manual/en/function.get-browser.php">get_browser()</a>
	 *         to tailor your page's output to the capabilities of the user
	 *         agent.
	 *         <strong>Note:</strong> Note that when using ISAPI with IIS, the
	 *         value will be off if the request was not made through the HTTPS
	 *         protocol.
	 */
	function httpUserAgent() {
		return $this->server ['HTTP_USER_AGENT'];
	}

	/**
	 * Set to a non-empty value if the script was queried through the HTTPS protocol.
	 * @return bool
	 */
	function https(): bool {
		$https = $this->server ['HTTPS'];
		// Note: Note that when using ISAPI with IIS, the value will be off if
		// the request was not made through the HTTPS protocol.
		return ! empty($https) && $https !== 'off';
	}

	/**
	 * alias of Server::https() // TODO: inline link?
	 */
	function isSecure() {
		return $this->https ();
	}

	/**
	 *
	 * @return string The IP address from which the user is viewing the current
	 *         page.
	 */
	function remoteAddress() {
		return isset ( $this->server ['REMOTE_ADDR'] ) ? $this->server ['REMOTE_ADDR'] : IPv4Address::LOCALHOST;
	}

	/**
	 *
	 * @return string The Host name from which the user is viewing the current
	 *         page. The reverse dns lookup is based off the
	 *         <code>REMOTE_ADDR</code> of the user.
	 */
	function remoteHost() {
		if (! isset ( $this->server ['REMOTE_HOST'] )) {
			$message = 'Your web server must be configured to create this variable. For example in Apache you\'ll need HostnameLookups On inside httpd.conf for it to exist. See also gethostbyaddr().';
			trigger_error ( $message, E_USER_WARNING );
		}
		return $this->server ['REMOTE_HOST'];
	}

	/**
	 *
	 * @return integer The port being used on the user's machine to communicate
	 *         with the web server.
	 */
	function remotePort() {
		return $this->server ['REMOTE_PORT'];
	}

	/**
	 *
	 * @return string The authenticated user.
	 */
	function remoteUser() {
		return $this->server ['REMOTE_USER'];
	}

	/**
	 *
	 * @return string The authenticated user if the request is internally
	 *         redirected.
	 */
	function redirectRemoteUser() {
		return $this->server ['REDIRECT_REMOTE_USER'];
	}

	/**
	 *
	 * @return string The absolute pathname of the currently executing script.
	 *         <strong>Note:</strong> If a script is executed with the CLI, as a
	 *         relative path, such as <code>file.php</code> or
	 *         <code>../file.php<code></code>,
	 *         <code>$_SERVER['SCRIPT_FILENAME']</code> will contain the
	 *         relative path specified by the user.
	 */
	function scriptFilename() {
		return $this->server ['SCRIPT_FILENAME'];
	}

	/**
	 *
	 * @return string The value given to the SERVER_ADMIN (for Apache) directive
	 *         in the web server configuration file. If the script is running on
	 *         a virtual host, this will be the value defined for that virtual
	 *         host.
	 */
	function serverAdmin() {
		return $this->server ['SERVER_ADMIN'];
	}

	/**
	 *
	 * @return integer The port on the server machine being used by the web
	 *         server for communication. For default setups, this will be
	 *         <code>'80</code>'; using SSL, for instance, will change this to
	 *         whatever your defined secure HTTP port is.
	 *         <strong>Note:</strong> Under the Apache 2, you must set
	 *         <code>UseCanonicalName = On</code>, as well as
	 *         <code>UseCanonicalPhysicalPort = On</code> in order to get the
	 *         physical (real) port, otherwise, this value can be spoofed and it
	 *         may or may not return the physical port value. It is not safe to
	 *         rely on this value in security-dependent contexts.
	 */
	function serverPort() {
		return $this->server ['SERVER_PORT'];
	}

	/**
	 *
	 * @return string String containing the server version and virtual host name
	 *         which are added to server-generated pages, if enabled.
	 */
	function serverSignature() {
		return $this->server ['SERVER_SIGNATURE'];
	}

	/**
	 *
	 * @return string Filesystem- (not document root-) based path to the current
	 *         script, after the server has done any virtual-to-real mapping.
	 *         <strong>Note:</strong> As of PHP 4.3.2, PATH_TRANSLATED is no
	 *         longer set implicitly under the Apache 2 SAPI in contrast to the
	 *         situation in Apache 1, where it's set to the same value as the
	 *         SCRIPT_FILENAME server variable when it's not populated by
	 *         Apache. This change was made to comply with the CGI specification
	 *         that PATH_TRANSLATED should only exist if PATH_INFO is defined.
	 *         Apache 2 users may use <code>AcceptPathInfo = On</code> inside
	 *         <code>httpd.conf</code> to define PATH_INFO.
	 */
	function pathTranslated() {
        return $this->server['PATH_TRANSLATED'];
    }

	/**
	 * Contains the current script's path.
	 * This is useful for pages which need to point to themselves. The <a
	 * href="http://www.php.net/manual/en/language.constants.predefined.php">__FILE__</a>
	 * constant contains the full path and filename of the current (i.e.
	 * included) file.
	 *
	 * @return string The current script's path.
	 */
	function scriptName() {
		return $this->server ['SCRIPT_NAME'];
	}

	/**
	 *
	 * @return string The URI which was given in order to access this page; for
	 *         instance, <code>'/index.html</code>'.
	 */
	function requestURI() {
		return $this->server ['REQUEST_URI'];
	}

	/**
	 * When doing Digest HTTP authentication this variable is set to the
	 * 'Authorization' header sent by the client (which you should then use to
	 * make the appropriate validation).
	 *
	 * @return string The 'Authorization' header sent by the client
	 */
	function authenticationDigest() {
		return $this->server ['PHP_AUTH_DIGEST'];
	}

	/**
	 * When doing HTTP authentication this variable is set to the username
	 * provided by the user.
	 *
	 * @return string authentication username
	 */
	function authenticationUser() {
		return $this->server ['PHP_AUTH_USER'];
	}

	/**
	 * When doing HTTP authentication this variable is set to the password
	 * provided by the user.
	 *
	 * @return string authentication password
	 */
	function authenticationPassword() {
		return $this->server ['PHP_AUTH_PW'];
	}

	/**
	 * When doing HTTP authenticated this variable is set to the authentication
	 * type.
	 *
	 * @return string authentication type
	 */
	function authenticationType() {
		return $this->server ['AUTH_TYPE'];
	}

	/**
	 * Contains any client-provided pathname information trailing the actual
	 * script filename but preceding the query string, if available.
	 * For instance, if the current script was accessed via the URL
	 * <code>http://www.example.com/php/path_info.php/some/stuff?foo=bar</code>,
	 * then <code>$_SERVER['PATH_INFO']</code> would contain
	 * <code>/some/stuff</code>.
	 *
	 * @return string client-provided pathname information trailing the actual
	 *         script filename but preceding the query string, if available
	 */
	function pathInformation() {
		return $this->server ['PATH_INFO'];
	}

	/**
	 *
	 * @return string Original version of <code>'PATH_INFO</code>' before being
	 *         processed by PHP.
	 */
	function originalPathInformation() {
		return $this->server ['ORIG_PATH_INFO'];
	}

}