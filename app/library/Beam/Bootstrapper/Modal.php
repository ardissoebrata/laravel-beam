<?php namespace Beam\Bootstrapper;

use Bootstrapper\Helpers;

/**
 * Class for creating Twitter Bootstrap Modals.
 *
 * @category   HTML/UI
 * @package    Boostrapper
 * @subpackage Twitter
 * @author     Patrick Talmadge - <ptalmadge@gmail.com>
 * @author     Maxime Fabre - <ehtnam6@gmail.com>
 * @author     Patrick Rose - <pjr0911025@gmail.com>
 * @license    MIT License <http://www.opensource.org/licenses/mit>
 * @link       http://laravelbootstrapper.phpfogapp.com/
 *
 * @see        http://twitter.github.com/bootstrap/
 */
class Modal {

    protected $attributes;

    protected $header;

    protected $body;

    protected $footer;

    public static function create($id, $attributes = null) {
        $attributes = Helpers::add_class($attributes, $id, "id");

        return new static($attributes);
    }

    public static function withHeader($headerText, $id, $attributes = null) {
        $attributes = Helpers::add_class($attributes, $id, "id");
        $modal = new static($attributes, $headerText);
        return $modal;
    }

    public static function withBody($bodyText, $id, $attributes = null) {
        $attributes = Helpers::add_class($attributes, $id, "id");
        return new static($attributes, null, $bodyText);
    }

    public static function withFooter($footerText, $id, $attributes = null) {
        $attributes = Helpers::add_class($attributes, $id, "id");
        return new static($attributes, null, null, $footerText);
    }

    public function __construct($attributes, $header = null, $body = null, $footer = null) {
        $this->attributes = $attributes;
        $this->header = $header;
        $this->body = $body;
        $this->footer = $footer;
    }

    public function header($headerText) {
        $this->header = $headerText;
        return $this;
    }

    public function body($bodyText) {
        $this->body = $bodyText;
        return $this;
    }

    public function footer($footerText) {
	$this->footer = $footerText;
	return $this;
    }

    public function render() {
        $this->attributes = Helpers::add_class($this->attributes, 'modal fade');
        $this->attributes = Helpers::add_class($this->attributes, "true", 'aria-hidden');
		
		$labelId = Helpers::rand_string(12);
		$this->attributes = Helpers::add_class($this->attributes, $labelId, 'aria-labelledby');
		
        // Open the modal
        $string = '<div' . Helpers::getContainer('html')->attributes($this->attributes) . '>';
		$string .= '<div class="modal-dialog">';
		$string .= '<div class="modal-content">';
        // Add the header
        $string .= '<div class="modal-header">';
        $string .= '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>';
        if ($this->header) {
            $string .= '<h4 id="' . $labelId . '" class="modal-title">' . $this->header . '</h4>';
        }
        $string .= '</div>';
        if ($this->body) {
            $string .= '<div class="modal-body">';
            $string .= $this->body;
            $string .= '</div>';
        }
        if ($this->footer) {
            $string .= '<div class="modal-footer">';
            $string .= $this->footer;
            $string .= '</div>';
        }
        return $string . '</div></div></div>';
    }

    public function __toString() {
        return $this->render();
    }

}
