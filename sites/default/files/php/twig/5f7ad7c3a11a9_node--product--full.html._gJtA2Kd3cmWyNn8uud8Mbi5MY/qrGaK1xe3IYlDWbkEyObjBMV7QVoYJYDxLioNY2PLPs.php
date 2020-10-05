<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/marketplace/templates/node--product--full.html.twig */
class __TwigTemplate_d5059ce334c4d9ecc2eee9bff99c3f25d76623f2af5771060d95bbd870388cdb extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["set" => 63, "if" => 77, "trans" => 87];
        $filters = ["clean_class" => 65, "escape" => 73];
        $functions = ["attach_library" => 73];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'trans'],
                ['clean_class', 'escape'],
                ['attach_library']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 63
        $context["classes"] = [0 => "node", 1 => ("node--type-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed($this->getAttribute(        // line 65
($context["node"] ?? null), "bundle", [])))), 2 => (($this->getAttribute(        // line 66
($context["node"] ?? null), "isPromoted", [], "method")) ? ("node--promoted") : ("")), 3 => (($this->getAttribute(        // line 67
($context["node"] ?? null), "isSticky", [], "method")) ? ("node--sticky") : ("")), 4 => (( !$this->getAttribute(        // line 68
($context["node"] ?? null), "isPublished", [], "method")) ? ("node--unpublished") : ("")), 5 => ((        // line 69
($context["view_mode"] ?? null)) ? (("node--view-mode-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["view_mode"] ?? null))))) : ("")), 6 => "clearfix"];
        // line 73
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->attachLibrary("classy/node"), "html", null, true);
        echo "
<article";
        // line 74
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method")), "html", null, true);
        echo ">
  <header>
    ";
        // line 76
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null)), "html", null, true);
        echo "
    ";
        // line 77
        if ( !($context["page"] ?? null)) {
            // line 78
            echo "      <h2";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["title_attributes"] ?? null), "addClass", [0 => "node__title"], "method")), "html", null, true);
            echo ">
        <a href=\"";
            // line 79
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["url"] ?? null)), "html", null, true);
            echo "\" rel=\"bookmark\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["label"] ?? null)), "html", null, true);
            echo "</a>
      </h2>
    ";
        }
        // line 82
        echo "    ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null)), "html", null, true);
        echo "
    ";
        // line 83
        if (($context["display_submitted"] ?? null)) {
            // line 84
            echo "      <div class=\"node__meta\">
        ";
            // line 85
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["author_picture"] ?? null)), "html", null, true);
            echo "
        <span";
            // line 86
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["author_attributes"] ?? null)), "html", null, true);
            echo ">
          ";
            // line 87
            echo t("Submitted by @author_name on @date", array("@author_name" => ($context["author_name"] ?? null), "@date" => ($context["date"] ?? null), ));
            // line 88
            echo "        </span>
        ";
            // line 89
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["metadata"] ?? null)), "html", null, true);
            echo "
      </div>
    ";
        }
        // line 92
        echo "  </header>
  <div";
        // line 93
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content_attributes"] ?? null), "addClass", [0 => "node__content", 1 => "clearfix"], "method")), "html", null, true);
        echo ">
    <div class=\"product-summary-info\">
      ";
        // line 95
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_images", [])), "html", null, true);
        echo "
      <div class=\"group-info\">
        <h1>
          <span>";
        // line 98
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["node_title"] ?? null)), "html", null, true);
        echo "</span>
        </h1>
        <div class=\"field-product-brand\">
          ";
        // line 101
        echo t("<span>by </span>", array());
        // line 102
        echo "          ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_brands", [])), "html", null, true);
        echo "
        </div>
        ";
        // line 104
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_old_price", [])), "html", null, true);
        echo "
        ";
        // line 105
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_discount_percentage", [])), "html", null, true);
        echo "
        ";
        // line 106
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_price", [])), "html", null, true);
        echo "
<!--         <div class=\"field field-type-commerce-product-reference\">
          <form action=\"\" class=\"commerce-add-to-cart\">
            <div class=\"form-item form-type-textfield form-item-quantity add-quantity-button\">
              <span class=\"btn decrease\" id=\"quantity-decrease\"></span>
              <label for=\"edit-quantity\">Quantity </label>
              <input type=\"text\" id=\"edit-quantity\" name=\"quantity\" value=\"1\" size=\"5\" maxlength=\"128\" class=\"form-text\">
              <span class=\"btn increase\" id=\"quantity-increase\"></span>
            </div>
            <input id=\"add-to-cart\" name=\"op\" value=\"Add to cart\" class=\"form-submit\" type=\"submit\">
          </form>
        </div> -->
        ";
        // line 118
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_product", [])), "html", null, true);
        echo "
        ";
        // line 119
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_stores", [])), "html", null, true);
        echo "
        ";
        // line 120
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_short_description", [])), "html", null, true);
        echo "
      </div>
    </div>
    ";
        // line 123
        echo t("<div class=\"product-detail-tabs\">
      <a id=\"hover-product-detail\" href=\"#product-detail\">Product Details</a>
      <a id=\"hover-production-specifications\" href=\"#production-specifications\">Production Specifications</a>
      <a id=\"hover-comments\" href=\"#comments-region\">Reviews</a>
    </div>", array());
        // line 130
        echo "    <div class=\"product-deteil-info\">
      <div id=\"product-detail\" class=\"group-product-detail\">
        ";
        // line 132
        echo t("<h3>Product Detail</h3>", array());
        // line 133
        echo "        ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "body", [])), "html", null, true);
        echo "
      </div>
      <div id=\"production-specifications\" class=\"group-product-specifications\">
        ";
        // line 136
        echo t("<h3>Specifications</h3>", array());
        // line 137
        echo "        ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "field_specifications", [])), "html", null, true);
        echo "
      </div>
      <div id=\"comments-region\" class=\"group-product-comments\">
        ";
        // line 140
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "links", [])), "html", null, true);
        echo "
        ";
        // line 141
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["content"] ?? null), "comment", [])), "html", null, true);
        echo "
      </div>
    </div>
  </div>
</article>
";
    }

    public function getTemplateName()
    {
        return "themes/marketplace/templates/node--product--full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  216 => 141,  212 => 140,  205 => 137,  203 => 136,  196 => 133,  194 => 132,  190 => 130,  184 => 123,  178 => 120,  174 => 119,  170 => 118,  155 => 106,  151 => 105,  147 => 104,  141 => 102,  139 => 101,  133 => 98,  127 => 95,  122 => 93,  119 => 92,  113 => 89,  110 => 88,  108 => 87,  104 => 86,  100 => 85,  97 => 84,  95 => 83,  90 => 82,  82 => 79,  77 => 78,  75 => 77,  71 => 76,  66 => 74,  62 => 73,  60 => 69,  59 => 68,  58 => 67,  57 => 66,  56 => 65,  55 => 63,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/marketplace/templates/node--product--full.html.twig", "C:\\xampp\\htdocs\\new\\themes\\marketplace\\templates\\node--product--full.html.twig");
    }
}
