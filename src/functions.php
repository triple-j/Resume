<?php
function alink($link, $prefix="http://") {
    return "<a href=\"{$prefix}{$link}\" target=\"_blank\">{$link}</a>";
}

function email($link) {
    return getObfuscatedEmailLink($link);
}

/**
 * Alexei Tenitski -- http://stackoverflow.com/a/12592364
 */
function getObfuscatedEmailAddress($email)
{
    $alwaysEncode = array('.', ':', '@');

    $result = '';

    // Encode string using oct and hex character codes
    for ($i = 0; $i < strlen($email); $i++)
    {
        // Encode 25% of characters including several that always should be encoded
        if (in_array($email[$i], $alwaysEncode) || mt_rand(1, 100) < 25)
        {
            if (mt_rand(0, 1))
            {
                $result .= '&#' . ord($email[$i]) . ';';
            }
            else
            {
                $result .= '&#x' . dechex(ord($email[$i])) . ';';
            }
        }
        else
        {
            $result .= $email[$i];
        }
    }

    return $result;
}

/**
 * Alexei Tenitski -- http://stackoverflow.com/a/12592364
 */
function getObfuscatedEmailLink($email, $params = array())
{
    if (!is_array($params))
    {
        $params = array();
    }

    // Tell search engines to ignore obfuscated uri
    if (!isset($params['rel']))
    {
        $params['rel'] = 'nofollow';
    }

    $neverEncode = array('.', '@', '+'); // Don't encode those as not fully supported by IE & Chrome

    $urlEncodedEmail = '';
    for ($i = 0; $i < strlen($email); $i++)
    {
        // Encode 25% of characters
        if (!in_array($email[$i], $neverEncode) && mt_rand(1, 100) < 25)
        {
            $charCode = ord($email[$i]);
            $urlEncodedEmail .= '%';
            $urlEncodedEmail .= dechex(($charCode >> 4) & 0xF);
            $urlEncodedEmail .= dechex($charCode & 0xF);
        }
        else
        {
            $urlEncodedEmail .= $email[$i];
        }
    }

    $obfuscatedEmail = getObfuscatedEmailAddress($email);
    $obfuscatedEmailUrl = getObfuscatedEmailAddress('mailto:' . $urlEncodedEmail);

    $link = '<a href="' . $obfuscatedEmailUrl . '"';
    foreach ($params as $param => $value)
    {
        $link .= ' ' . $param . '="' . htmlspecialchars($value). '"';
    }
    $link .= '>' . $obfuscatedEmail . '</a>';

    return $link;
}