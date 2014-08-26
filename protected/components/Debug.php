<?php

class Debug
{
	/**
	 * Dumps variables similar to print_r with few enchancements
	 *
	 * @param mixed $var,...
	 */
	static function varDump($var)
	{
		$args = func_get_args();

		if (count($args) > 1 && is_bool($args[count($args)-1]))
			$exit = array_pop($args);
		else
			$exit = true;

		ob_start();
		call_user_func_array('var_dump', $args);
		$ret = ob_get_contents();
		ob_end_clean();

		$ret = str_replace('["', '[', $ret);
		$ret = str_replace('"]', ']', $ret);
		$ret = preg_replace('/]=>\s+/', '] => ', $ret);

		if ($_SERVER['SERVER_PORT']
//            && $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'
        )
		{
			$ret = htmlspecialchars($ret);
			$ret = preg_replace(array(
				'/\[([^\]]+)\]/',
				'/(^|=&gt; )((?:array|int|resource|string)\(\d+\))/',
				'/([\[\{\}\]])/',
				'/(&quot;.*?&quot;)/s',
			), array(
				'[<span class="key-name">$1</span>]',
				'$1<span class="var-type">$2</span>',
				'<span class="bracket">$1</span>',
				'<span class="var-value">$1</span>',
			), $ret);

			$ret = <<<HTML
<style type="text/css">
.key-name { font-weight: bold; }
.var-type { color: #00f; }
.bracket { color: #800; font-weight: bold }
.var-value { color: 080; }
</style>
<pre>{$ret}</pre>
HTML;
		}

		echo $ret;

		if ($exit)
			exit;
	}
}