<?php

/* feeds.twig */
class __TwigTemplate_e53cd29788217a8bb28b64688e9448d69d114ef38f5cb1a16eeb490c96bd8fcb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("layout.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "    <table>
        ";
        // line 5
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["feeds"]) ? $context["feeds"] : $this->getContext($context, "feeds")));
        foreach ($context['_seq'] as $context["_key"] => $context["feed"]) {
            // line 6
            echo "            <tr>
                <td>
                    ";
            // line 8
            if (($this->getAttribute($context["feed"], "type", array()) == 0)) {
                echo "ATOM
                    ";
            } else {
                // line 9
                echo "RSS";
            }
            // line 10
            echo "                </td>
                <td>&nbsp</td>
                <td>";
            // line 12
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["feed"], "date", array()), "Y-m-d H:i"), "html", null, true);
            echo "</td>
                <td>&nbsp</td>
                <td>
                    <a href=\"";
            // line 15
            echo twig_escape_filter($this->env, $this->getAttribute($context["feed"], "link", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["feed"], "title", array()), "html", null, true);
            echo "</a>
                </td>
                <td>&nbsp</td>
                <td>";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute($context["feed"], "description", array()), "html", null, true);
            echo "</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['feed'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "    </table>
";
    }

    public function getTemplateName()
    {
        return "feeds.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 21,  76 => 18,  68 => 15,  62 => 12,  58 => 10,  55 => 9,  50 => 8,  46 => 6,  42 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
