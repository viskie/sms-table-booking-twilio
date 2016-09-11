<?php
/*~ class.phpmailer.php
.---------------------------------------------------------------------------.
|  Software: PHPMailer - PHP email class                                    |
|   Version: 5.2                                                            |
|      Site: https://code.google.com/a/apache-extras.org/p/phpmailer/       |
| ------------------------------------------------------------------------- |
|     Admin: Jim Jagielski (project admininistrator)                        |
|   Authors: Andy Prevost (codeworxtech) codeworxtech@users.sourceforge.net |
|          : Marcus Bointon (coolbru) coolbru@users.sourceforge.net         |
|          : Jim Jagielski (jimjag) jimjag@gmail.com                        |
|   Founder: Brent R. Matzelle (original founder)                           |
| Copyright (c) 2010-2011, Jim Jagielski. All Rights Reserved.               |
| Copyright (c) 2004-2009, Andy Prevost. All Rights Reserved.               |
| Copyright (c) 2001-2003, Brent R. Matzelle                                |
| ------------------------------------------------------------------------- |
|   License: Distributed under the Lesser General Public License (LGPL)     |
|            http://www.gnu.org/copyleft/lesser.html                        |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
'---------------------------------------------------------------------------'
*/

/**
 * PHPMailer - PHP email transport class
 * NOTE: Requires PHP version 5 or later
 * @package PHPMailer
 * @author Andy Prevost
 * @author Marcus Bointon
 * @author Jim Jagielski
 * @copyright 2010 - 2011 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @version $Id: class.phpmailer.php 450 2010-06-23 16:46:33Z coolbru $
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

if (version_compare(PHP_VERSION, '5.0.0', '<') ) exit("Sorry, this version of PHPMailer will only run on PHP version 5 or greater!\n");

class PHPMailer {

  /////////////////////////////////////////////////
  // PROPERTIES, PUBLIC
  /////////////////////////////////////////////////

  /**
   * Email priority (1 = High, 3 = Normal, 5 = low).
   * @var int
   */
  public $Priority          = 3;

  /**
   * Sets the CharSet of the message.
   * @var string
   */
  public $CharSet           = 'iso-8859-1';

  /**
   * Sets the Content-type of the message.
   * @var string
   */
  public $ContentType       = 'text/plain';

  /**
   * Sets the Encoding of the message. Options for this are
   *  "8bit", "7bit", "binary", "base64", and "quoted-printable".
   * @var string
   */
  public $Encoding          = '8bit';

  /**
   * Holds the most recent mailer error message.
   * @var string
   */
  public $ErrorInfo         = '';

  /**
   * Sets the From email address for the message.
   * @var string
   */
  public $From              = 'root@localhost';

  /**
   * Sets the From name of the message.
   * @var string
   */
  public $FromName          = 'Root User';

  /**
   * Sets the Sender email (Return-Path) of the message.  If not empty,
   * will be sent via -f to sendmail or as 'MAIL FROM' in smtp mode.
   * @var string
   */
  public $Sender            = '';

  /**
   * Sets the Subject of the message.
   * @var string
   */
  public $Subject           = '';

  /**
   * Sets the Body of the message.  This can be either an HTML or text body.
   * If HTML then run IsHTML(true).
   * @var string
   */
  public $Body              = '';

  /**
   * Sets the text-only body of the message.  This automatically sets the
   * email to multipart/alternative.  This body can be read by mail
   * clients that do not have HTML email capability such as mutt. Clients
   * that can read HTML will view the normal Body.
   * @var string
   */
  public $AltBody           = '';

  /**
   * Stores the complete compiled MIME message body.
   * @var string
   * @access protected
   */
  protected $MIMEBody       = '';

  /**
   * Stores the complete compiled MIME message headers.
   * @