<?php

namespace Ob\HighchartsBundle\Highcharts;

/**
 * This class is part of the Ob/HighchartsBundle
 * See Highcharts documentation at http://www.highcharts.com/ref/
 *
 * @method Highchart colors(array $colors)
 * @method Highchart series(array $series)
 */
class Highchart extends AbstractChart implements ChartInterface
{
    /**
     * @param string $engine
     *
     * @return string
     */
    public function render($engine = 'jquery')
    {
        $chartJS = "";
        $chartJS .= $this->renderEngine($engine);
        $chartJS .= $this->renderOptions();
        $chartJS .= "\n    var " . (isset($this->chart->renderTo) ? $this->chart->renderTo : 'chart') . " = new Highcharts.Chart({\n";

        // Chart
        $chartJS .= $this->renderWithJavascriptCallback($this->chart->chart, "chart");

        // Colors
        $chartJS .= $this->renderColors();

        // Credits
        $chartJS .= $this->renderCredits();

        // Exporting
        $chartJS .= $this->renderWithJavascriptCallback($this->exporting->exporting, "exporting");

        // Labels

        // Legend
        $chartJS .= $this->renderWithJavascriptCallback($this->legend->legend, "legend");

        // Loading
        // Navigation
        // Pane
        $chartJS .= $this->renderPane();

        // PlotOptions
        $chartJS .= $this->renderWithJavascriptCallback($this->plotOptions->plotOptions, "plotOptions");

        // Series
        $chartJS .= $this->renderWithJavascriptCallback($this->series, "series");

        // Drilldown
        $chartJS .= $this->renderDrilldown();

        // Subtitle
        $chartJS .= $this->renderSubtitle();

        // Symbols

        // Title
        $chartJS .= $this->renderTitle();

        // Tooltip
        $chartJS .= $this->renderWithJavascriptCallback($this->tooltip->tooltip, "tooltip");

        // xAxis
        $chartJS .= $this->renderXAxis();

        // yAxis
        $chartJS .= $this->renderYAxis();

        // trim last trailing comma and close parenthesis
        $chartJS = rtrim($chartJS, ",\n") . "\n    });\n";

        if ($engine != false) {
            $chartJS .= "});\n";
        }

        return trim($chartJS);
    }

    /**
     * @return string
     */
    private function renderOptions()
    {
        $result = "";

        if (get_object_vars($this->global->global) || get_object_vars($this->lang->lang)) {
            $result .= "\n    Highcharts.setOptions({";
            $result .= $this->renderGlobal();
            $result .= $this->renderLang();
            $result .= "    });\n";
        }

        return $result;
    }

    /**
     * @return string
     */
    private function renderGlobal()
    {
        if (get_object_vars($this->global->global)) {
            return "global: " . json_encode($this->global->global) . ",\n";
        }

        return "";
    }

    /**
     * @return string
     */
    private function renderLang()
    {
        if (get_object_vars($this->lang->lang)) {
            return "lang: " . json_encode($this->lang->lang) . ",\n";
        }

        return "";
    }

    /**
     * @return string
     */
    private function renderPane()
    {
        if (get_object_vars($this->pane->pane)) {
            return "pane: " . json_encode($this->pane->pane) . ",\n";
        }

        return "";
    }

    /**
     * @return string
     */
    private function renderDrilldown()
    {
        if (get_object_vars($this->drilldown->drilldown)) {
            return "drilldown: " . json_encode($this->drilldown->drilldown) . ",\n";
        }

        return "";
    }
}
