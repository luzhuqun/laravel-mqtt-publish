<?php

namespace Lzq\Mqtt;

use Lzq\Mqtt\lib\Mqtt;

class SamConnection extends Sam
{
    public $debug = false;
    public $errNo = 0;
    public $error = '';
    public $connection;

    public function __construct()
    {
        if ($this->debug) {
            $this->e('SAMConnection()');
        }

        if ($this->debug) {
            $this->x('SAMConnection()');
        }
    }

    public function create($proto)
    {
        if ($this->debug) {
            $this->e("SAMConnection.Create(proto=$proto)");
        }
        $rc = false;
        /* search the PHP config for a factory to use...    */
        $x = get_cfg_var('sam.factory.'.$proto);
        if ($this->debug) {
            $this->t('SAMConnection.Create() get_cfg_var() "'.$x.'"');
        }

        /* If there is no configuration (php.ini) entry for this protocol, default it.  */
        if (strlen($x) == 0) {
            /* for every protocol other than MQTT assume we will use XMS    */
            if ($proto != 'mqtt') {
                $x = 'xms';
                if (!class_exists('SAMXMSConnection')) {
                    global $eol;
                    $l = (strstr(PHP_OS, 'WIN') ? 'php_' : '').'sam_xms.'.(strstr(PHP_OS, 'WIN') ? 'dll' : 'so');
                    echo $eol.'<font color="red"><b>Unable to access SAM XMS capabilities. Ensure the '.$l.' library is defined as an extension.</b></font>'.$eol;
                    $rc = false;
                } else {
                    $rc = new SAMXMSConnection();
                }
            } else {
                $x = 'mqtt';
                $rc = new Mqtt();
            }
        }

        if ($this->debug && $rc) {
            $this->t('SAMConnection.Create() rc = '.get_class($rc));
        }
        if ($this->debug) {
            $this->x('SAMConnection.Create()');
        }
        return $rc;
    }

    public function commit()
    {
        if ($this->debug) {
            $this->e('SAMConnection.Commit()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the method on the underlying connection object...   */
            $rc = $this->connection->commit($target, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Commit() commit failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Commit() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Connect
       --------------------------------- */
    public function connect($proto = '', $options = array())
    {
        if ($this->debug) {
            $this->e('SAMConnection.connect()');
        }
        $rc = false;

        if ($options['SAM_PORT'] == '') {
            $this->port = 1883;
        } else {
            $this->port = $options['SAM_PORT'];
        }
        if ($options['SAM_HOST'] == '') {
            $this->host = 'localhost';
        } else {
            $this->host = $options['SAM_HOST'];
        }

        if ($proto == '') {
            $errNo = 101;
            $error = 'Incorrect number of parameters on connect call!';
            $rc = false;
        } else {
            $this->connection = $this->create($proto);
            if (!$this->connection) {
                $errNo = 102;
                $error = 'Unsupported protocol!';
                $rc = false;
            } else {
                if ($this->debug) {
                    $this->t("SAMConnection.Connect() connection created for protocol $proto");
                }

                $this->connection->setdebug($this->debug);

                /* Call the connect method on the newly created connection object...   */
                $rc = $this->connection->connect($proto, $options);
                $this->errNo = $this->connection->errNo;
                $this->error = $this->connection->error;
                if (!$rc) {
                    if ($this->debug) {
                        $this->t("SAMConnection.Connect() connect failed ($this->errNo) $this->error");
                    }
                } else {
                    $rc = true;
                }
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Connect() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Disconnect
       --------------------------------- */
    public function disconnect()
    {
        if ($this->debug) {
            $this->e('SAMConnection.Disconnect()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the method on the underlying connection object...   */
            $rc = $this->connection->Disconnect();
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Disconnect() Disconnect failed ($this->errNo) $this->error");
                }
            } else {
                $rc = true;
                $this->connection = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Disconnect() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        IsConnected
       --------------------------------- */
    public function isConnected()
    {
        if ($this->debug) {
            $this->e('SAMConnection.IsConnected()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the method on the underlying connection object...   */
            $rc = $this->connection->isconnected();
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.IsConnected() isconnected failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.IsConnected() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Peek
       --------------------------------- */
    public function peek($target, $options = array())
    {
        if ($this->debug) {
            $this->e('SAMConnection.Peek()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the method on the underlying connection object...   */
            $rc = $this->connection->peek($target, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Peek() peek failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Peek() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        PeekAll
       --------------------------------- */
    public function peekAll($target, $options = array())
    {
        if ($this->debug) {
            $this->e('SAMConnection.PeekAll()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the method on the underlying connection object...   */
            $rc = $this->connection->peekall($target, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.PeekAll() peekall failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.PeekAll() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Receive
       --------------------------------- */
    public function receive($target, $options = array())
    {
        if ($this->debug) {
            $this->e('SAMConnection.Receive()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the receive method on the underlying connection object...   */
            $rc = $this->connection->receive($target, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Receive() receive failed ($this->errNo) $this->error");
                }
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Receive() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Remove
       --------------------------------- */
    public function remove($target, $options = array())
    {
        if ($this->debug) {
            $this->e('SAMConnection.Remove()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the method on the underlying connection object...   */
            $rc = $this->connection->remove($target, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Remove() remove failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Remove() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Rollback
       --------------------------------- */
    public function rollback()
    {
        if ($this->debug) {
            $this->e('SAMConnection.Rollback()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the method on the underlying connection object...   */
            $rc = $this->connection->rollback($target, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Rollback() rollback failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Rollback() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Send
       --------------------------------- */
    public function send($target, $msg, $options = array())
    {
        if ($this->debug) {
            $this->e('SAMConnection.Send()');
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the send method on the underlying connection object...   */
            $rc = $this->connection->send($target, $msg, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Send() send failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Send() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        SetDebug
       --------------------------------- */
    public function setDebug($option = false)
    {
        if ($this->debug) {
            $this->e("SAMConnection.setDebug($option)");
        }

        $this->debug = $option;

        if ($this->connection) {
            $this->connection->setdebug($option);
        }

        if ($this->debug) {
            $this->x('SAMConnection.SetDebug()');
        }
        return;
    }

    /* ---------------------------------
        Subscribe
       --------------------------------- */
    public function subscribe($topic, $options = array())
    {
        if ($this->debug) {
            $this->e("SAMConnection.Subscribe($topic)");
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the subscribe method on the underlying connection object...   */
            $rc = $this->connection->subscribe($topic, $options);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.Subscribe() subscribe failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.Subscribe() rc=$rc");
        }
        return $rc;
    }

    /* ---------------------------------
        Unsubscribe
       --------------------------------- */
    public function unsubscribe($sub_id)
    {
        if ($this->debug) {
            $this->e("SAMConnection.unsubscribe($sub_id)");
        }
        $rc = true;

        if (!$this->connection) {
            $errNo = 106;
            $error = 'No active connection!';
            $rc = false;
        } else {
            /* Call the subscribe method on the underlying connection object...   */
            $rc = $this->connection->unsubscribe($sub_id);
            $this->errNo = $this->connection->errNo;
            $this->error = $this->connection->error;
            if (!$rc) {
                if ($this->debug) {
                    $this->t("SAMConnection.unsubscribe() unsubscribe failed ($this->errNo) $this->error");
                }
                $rc = false;
            }
        }

        if ($this->debug) {
            $this->x("SAMConnection.unsubscribe() rc=$rc");
        }
        return $rc;
    }
}