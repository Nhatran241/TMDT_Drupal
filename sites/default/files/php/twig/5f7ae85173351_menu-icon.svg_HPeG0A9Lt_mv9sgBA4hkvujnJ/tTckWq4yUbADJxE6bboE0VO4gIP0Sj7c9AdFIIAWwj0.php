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

/* core/profiles/demo_umami/themes/umami/images/svg/menu-icon.svg */
class __TwigTemplate_e98bda256252072f0647bab892cdf7442a5546c50cee7429e93fe377e0bc63a7 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = [];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
                [],
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
        echo "<svg width=\"23\" height=\"23\" viewBox=\"0 0 23 23\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><use xlink:href=\"#a\" fill=\"#5F635D\"/><use xlink:href=\"#a\" transform=\"translate(0 18)\" fill=\"#5F635D\"/><use xlink:href=\"#a\" transform=\"translate(0 9)\" fill=\"#5F635D\"/><defs><path id=\"a\" fill-rule=\"evenodd\" d=\"M0 0h23v5H0V0z\"/></defs></svg>
";
    }

    public function getTemplateName()
    {
        return "core/profiles/demo_umami/themes/umami/images/svg/menu-icon.svg";
    }

    public function getDebugInfo()
    {
        return array (  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "core/profiles/demo_umami/themes/umami/images/svg/menu-icon.svg", "C:\\xampp\\htdocs\\new\\core\\profiles\\demo_umami\\themes\\umami\\images\\svg\\menu-icon.svg");
    }
}
