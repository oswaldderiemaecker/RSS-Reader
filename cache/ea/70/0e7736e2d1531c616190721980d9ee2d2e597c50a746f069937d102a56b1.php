<?php

/* layout.twig */
class __TwigTemplate_ea700e7736e2d1531c616190721980d9ee2d2e597c50a746f069937d102a56b1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "
";
        // line 3
        echo "<!doctype html>

<html lang=\"fr-FR\">
<head>
    <meta charset=\"UTF-8\">
    <title>SilexSkeleton</title>
    <link rel=\"stylesheet\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("index.index"), "html", null, true);
        echo "bootstrap/css/bootstrap.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("index.index"), "html", null, true);
        echo "bootstrap/css/bootstrap-responsive.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("index.index"), "html", null, true);
        echo "css/default.css\">

    <script type=\"text/javascript\" src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getUrl("index.index"), "html", null, true);
        echo "bootstrap/js/bootstrap.js\"></script>
</head>
<body>
<header>
    <body data-spy=\"scroll\" data-target=\".navbar\">

    <div class=\"navbar navbar-inverse navbar-fixed-top\">
        <div class=\"navbar-inner\"><section id=\"I-F\" noNumber=\"1\">

                <div class=\"container\">
                    <a class=\"brand\" href=\"#\">SilexSkeleton</a>

                    <div class=\"nav-collapse collapse\">
                        <p class=\"navbar-text pull-right\">

                            <b>Nous sommes le ";
        // line 28
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "d/m/Y"), "html", null, true);
        echo " </b>
                        </p>
                        <ul class=\"nav\" role=\"navigation\">
                            <li><a href=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("index.index"), "html", null, true);
        echo "\">Accueil</a></li>
                            <li><a href=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("index.info"), "html", null, true);
        echo "\">Info</a></li>

                        </ul>
                    </div>
                </div>
        </div>
    </div>

</header>
<div id=\"content\">
    ";
        // line 42
        $this->displayBlock('content', $context, $blocks);
        // line 44
        echo "</div>

<footer>

</footer>

</body>
</html>
";
    }

    // line 42
    public function block_content($context, array $blocks = array())
    {
        // line 43
        echo "    ";
    }

    public function getTemplateName()
    {
        return "layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 43,  99 => 42,  87 => 44,  85 => 42,  72 => 32,  68 => 31,  62 => 28,  44 => 13,  39 => 11,  35 => 10,  31 => 9,  23 => 3,  20 => 1,);
    }
}
