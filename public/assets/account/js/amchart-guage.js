am5.ready(function() {

    var root = am5.Root.new("aml-risk-score-chart");
    root._logo.dispose();

    root.setThemes([am5themes_Animated.new(root)]);

    var chart = root.container.children.push(am5radar.RadarChart.new(root, {
        panX: false,
        panY: false,
        startAngle: 180,
        endAngle: 360
    }));

    var axisRenderer = am5radar.AxisRendererCircular.new(root, {
        innerRadius: -30,
        strokeOpacity: 0.1
    });

    axisRenderer.labels.template.set("forceHidden", true);
    axisRenderer.grid.template.set("forceHidden", true);

    var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation: 0,
        min: 0,
        max: 3,
        strictMinMax: true,
        renderer: axisRenderer
    }));

    var Item1 = xAxis.makeDataItem({});
    Item1.set("value", 0);
    Item1.set("endValue", 1);
    xAxis.createAxisRange(Item1);
    Item1.get("label").setAll({text: "Safe", forceHidden:false});
    Item1.get("axisFill").setAll({visible:true, fillOpacity:1, fill:'#55BF3B'});

    var Item2 = xAxis.makeDataItem({});
    Item2.set("value", 1);
    Item2.set("endValue", 2);
    xAxis.createAxisRange(Item2);
    Item2.get("label").setAll({text: "warning", forceHidden:false});
    Item2.get("axisFill").setAll({visible:true, fillOpacity:1, fill:'#DDDF0D'});

    var Item3 = xAxis.makeDataItem({});
    Item3.set("value", 2);
    Item3.set("endValue", 3);
    xAxis.createAxisRange(Item3);
    Item3.get("label").setAll({text: "Risk/Cautious", forceHidden:false});
    Item3.get("axisFill").setAll({visible:true, fillOpacity:1, fill:'#DF5353'});

        // Add clock hand
    var axisDataItem = xAxis.makeDataItem({});
    axisDataItem.set("value", 0.25);

    var bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
        sprite: am5radar.ClockHand.new(root, {
            radius: am5.percent(99)
        })
    }));

    xAxis.createAxisRange(axisDataItem);

    axisDataItem.get("grid").set("visible", false);

    axisDataItem.animate({
        key: "value",
        to: aml_risk_score,
        duration: 800,
        easing: am5.ease.out(am5.ease.cubic)
    });
});
