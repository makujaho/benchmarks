<?php

require_once 'general_config.php';

/**
 * Mini-timing-framework for benchmarking in PHP
 *
 * Class that save times so every execution adds up and we get a nice big 
 * number to determine which calls are faster or slower.
 *
 * @version 1.0.0
 * @author  MKzero <info@linux-web-development.de>
 */
abstract class benchframe {
    /**
     * Array that holds benmark timings
     *
     * @var     array
     * @access  protected
     */
    protected $times = array();

    /**
     * Names for the timings
     *
     * @var array
     */
    protected $times_names = array();

    /**
     * Version number, when this is different from the last version saved
     * to the time file, the times won't be added but instead appended as a
     * new array. This is especially useful if you alter your test order or
     * add new tests/timings.
     *
     * @var     int 
     * @access  protected
     */
    protected $version = 0;

    /**
     * String that contains the file name for the result file
     *
     * @var     string
     * @access  protected
     */
    protected $file;

    /**
     * Adds a new time to the timing array.
     *
     * Be aware that if you add a very small float number, PHP might show
     * its quirks.. 
     *
     * @access  public
     */
    public function add_timing($name = null) {
        if ($name === null) {
            prev($this->times_names);
            $name = key($this->times_names) + 1;
            next($this->times_names);
        }
        $this->times[] = microtime(true);
        $this->times_names[] = $name;
    }

    public function __construct() {
        $this->file = dirname(__FILE__) . "/results/" . get_called_class() . 
                        ".json";
    }

    public function __destruct() {
        if (is_file($this->file)) {
            $old_times = json_decode(file_get_contents($this->file), true);

            // If the version of the loaded times is not the same as the 
            // current version, we need to update the file
            if ((int) $old_times['version'] != (int) $this->version) {
                $times             = array();
                $times['version']  = (int) $this->version;
                $times['times']    = array();
                $times['names']    = array();
                $times['runs']     = 0;

                if (isset($old_times['old'])) {
                    $tmp = $old_times['old'];
                    unset($old_times['old']);

                    $times['old'] = array_merge($tmp, array(
                        'v'.$old_times['version'] => $old_times
                    ));
                } else {
                    $times['old'] = array(
                        "v".$old_times['version'] => $old_times
                    );
                }

                $old_times = $times;
            }
        } else {
            $old_times            = array();
            $old_times['version'] = (int) $this->version;
            $old_times['times']   = array();
            $old_times['names']   = array();
            $old_times['runs']    = 0;
        }
        
        reset($this->times);
        next($this->times);
        while(list($i,$t) = each($this->times)) {
            if(isset($old_times['times'][$i])) {
                $old_times['times'][$i] += ($t - $this->times[$i-1]);
            } else {
                $old_times['times'][$i] = ($t - $this->times[$i-1]);
            }
        }

        reset($this->times_names);
        next($this->times_names);
        while(list($i,$t) = each($this->times_names)) {
            if(isset($old_times['names'][$i]) && 
              $old_times['names'][$i] != $t) {
                trigger_error("Altered name for timing. Consider upgrading ".
                              "your version when changing your tests");
            }
            $old_times['names'][$i] = $t;
        }
        ++$old_times['runs'];

        file_put_contents($this->file, json_encode($old_times));
    }

    public function __toString() {
        $r = "";

        reset($this->times);
        next($this->times);
        while (list($i,$t) = each($this->times)) {
            $r .= "Time " . $this->times_names[$i] . ": " . 
                        ($t - $this->times[$i-1]) . PHP_EOL;
        }

        return $r;
    }
}
