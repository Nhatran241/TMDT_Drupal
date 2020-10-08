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

/* modules/contrib/we_megamenu/templates/we-megamenu-li.html.twig */
class __TwigTemplate_cf5159abeba0580c806cf14eadc85587300088627d0fe6a326d3147e0e8fc634 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 2];
        $filters = ["escape" => 1, "trim" => 4];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'trim'],
                []
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
        // line 1
        echo "<li ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null)), "html", null, true);
        echo ">
  ";
        // line 2
        if (twig_test_empty(($context["href"] ?? null))) {
            // line 3
            echo "    <a href='#' data-drupal-link-system-path=\"<front>\" class=\"we-megamenu-nolink\">
      ";
            // line 4
            if (($this->getAttribute(($context["attributes"] ?? null), "data-icon", [], "any", true, true) && twig_trim_filter($this->getAttribute(($context["attributes"] ?? null), "data-icon")))) {
                // line 5
                echo "        <i class=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "data-icon")), "html", null, true);
                echo "\"></i>
      ";
            }
            // line 8
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null)), "html", null, true);
            // line 9
            echo "</a>
  ";
        } else {
            // line 11
            echo "    <a class=\"we-mega-menu-li\" title=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "description")), "html", null, true);
            echo "\" href=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["href"] ?? null)), "html", null, true);
            echo "\" target=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "data-target")), "html", null, true);
            echo "\">
      ";
            // line 12
            if (($this->getAttribute(($context["attributes"] ?? null), "data-icon", [], "any", true, true) && twig_trim_filter($this->getAttribute(($context["attributes"] ?? null), "data-icon")))) {
                // line 13
                echo "        <i class=\"";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "data-icon")), "html", null, true);
                echo "\"></i>
      ";
            }
            // line 16
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null)), "html", null, true);
            // line 18
            if (($this->getAttribute(($context["attributes"] ?? null), "data-caption", [], "any", true, true) && twig_trim_filter($this->getAttribute(($context["attributes"] ?? null), "data-caption")))) {
                // line 19
                echo "        <span class=\"we-mega-menu-caption\">";
                echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "data-caption")), "html", null, true);
                echo "</span>
      ";
            }
            // line 21
            echo "    </a>
  ";
        }
        // line 23
        echo "  ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null)), "html", null, true);
        echo "
</li>";
    }

    public function getTemplateName()
    {
        return "modules/contrib/we_megamenu/templates/we-megamenu-li.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 23,  106 => 21,  100 => 19,  98 => 18,  96 => 16,  90 => 13,  88 => 12,  79 => 11,  75 => 9,  73 => 8,  67 => 5,  65 => 4,  62 => 3,  60 => 2,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/we_megamenu/templates/we-megamenu-li.html.twig", "C:\\xampp\\htdocs\\new\\modules\\contrib\\we_megamenu\\templates\\we-megamenu-li.html.twig");
    }
}
