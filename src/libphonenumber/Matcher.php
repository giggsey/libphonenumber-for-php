<?php

namespace libphonenumber;

/**
 * Matcher for various regex matching
 *
 * Note that this is NOT the same as google's java PhoneNumberMatcher class.
 * This class is a minimal port of java's built-in matcher class, whereas PhoneNumberMatcher
 * is designed to recognize phone numbers embedded in any text.
 */
class Matcher
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var array
     */
    private $groups = array();

    /**
     * @param string $pattern
     * @param string $subject
     */
    public function __construct($pattern, $subject)
    {
        $this->pattern = str_replace('/', '\/', $pattern);
        $this->subject = $subject;
    }

    private function doMatch($type = 'find')
    {
        $final_pattern = '(?:' . $this->pattern . ')';
        switch ($type) {
            case 'matches':
                $final_pattern = '^' . $final_pattern . '$';
                break;
            case 'lookingAt':
                $final_pattern = '^' . $final_pattern;
                break;
            case 'find':
            default:
                // no changes	    
                break;
        }
        $final_pattern = '/' . $final_pattern . '/x';
        return (preg_match($final_pattern, $this->subject, $this->groups, PREG_OFFSET_CAPTURE) == 1) ? true : false;
    }

    /**
     * @return bool
     */
    public function matches()
    {
        return $this->doMatch('matches');
    }

    /**
     * @return bool
     */
    public function lookingAt()
    {
        return $this->doMatch('lookingAt');
    }

    /**
     * @return bool
     */
    public function find()
    {
        return $this->doMatch('find');
    }

    /**
     * @return int
     */
    public function groupCount()
    {
        if (empty($this->groups)) {
            return null;
        } else {
            return count($this->groups) - 1;
        }
    }

    /**
     * @param int $group
     * @return string
     */
    public function group($group = null)
    {
        if (!isset($group)) {
            $group = 0;
        }
        return (isset($this->groups[$group][0])) ? $this->groups[$group][0] : null;
    }

    /**
     * @param int|null $group
     * @return int
     */
    public function end($group = null)
    {
        if (!isset($group) || $group === null) {
            $group = 0;
        }
        if (!isset($this->groups[$group])) {
            return null;
        }
        return $this->groups[$group][1] + strlen($this->groups[$group][0]);
    }

    public function start($group = null)
    {
        if (isset($group) || $group === null) {
            $group = 0;
        }
        if (!isset($this->groups[$group])) {
            return null;
        }

        return $this->groups[$group][1];
    }

    /**
     * @param string $replacement
     * @return string
     */
    public function replaceFirst($replacement)
    {
        return preg_replace('/' . $this->pattern . '/x', $replacement, $this->subject, 1);
    }

    /**
     * @param string $replacement
     * @return string
     */
    public function replaceAll($replacement)
    {
        return preg_replace('/' . $this->pattern . '/x', $replacement, $this->subject);
    }

    /**
     * @param string $input
     * @return Matcher
     */
    public function reset($input = "")
    {
        $this->subject = $input;

        return $this;
    }
}
