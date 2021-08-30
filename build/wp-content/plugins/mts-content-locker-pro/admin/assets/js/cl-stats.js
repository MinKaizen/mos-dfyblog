/*!
* Content Locker
*
* https://mythemeshop.com/plugins/content-locker/
*
* (c) Copyright mythemeshop.com
*
* @author  MyThemeShop
*/
/*global google*/
;(function( $ ) {

	'use strict';

	window.CL_Statistics = {

		// Default chart options that will be changed when the chart is drawing
        defaults: {
            isStacked: true,
            fontSize: 11,
            legend: {
                position: 'in',
                format: 'dd MMM'
            },
            pointSize: 7,
            lineWidth: 3,
            tooltip: {
                showColorCode: true,
                textStyle: { fontSize: '11', color: '#333' }
            },
            colors: [],
            hAxis: {
                baselineColor: '#fff',
                gridlines: { color: '#fff' },
                textStyle: { fontSize: '11', color: '#333' },
                format: 'dd MMM'
            },
            vAxis: {
                baselineColor: '#111',
                gridlines: { color: '#f6f6f6' },
                textPosition: 'in',
                textStyle: { fontSize: '11', color: '#333' }
            },
            chartArea: { height: '250', width: '100%', top: 0 }
        },

		init: function() {

			var self = this;

			this.init_button_selector();
            this.init_date_range_selector();
			this.init_auto_redirect();

            $( window ).resize(function() {
                self.redraw_chart();
            });
		},

		init_auto_redirect: function() {

			$( '#cl-locker-item-selector' ).on( 'change', function() {
				$( this ).next( 'input' ).trigger( 'click' );
			});
		},

		/**
         * Inits buttons selector
         */
        init_button_selector: function() {

			var self = this,
				selectors = window.cl_chart_selectors;

            $( '.mts-cl-selector-item' )
                .addClass( 'mts-cl-inactive' )
                .removeClass( 'mts-cl-active' );

            for ( var index in selectors ) {
                $(  '.mts-cl-selector-' + selectors[index] )
                    .addClass( 'mts-cl-active' )
                    .removeClass( 'mts-cl-inactive' );
            }

            $(  '.mts-cl-selector-item'  ).click(function() {

				var selector = $( this ).data( 'selector' ),
					$item = $(  '.mts-cl-selector-' + selector );

				if ( $item.hasClass( 'mts-cl-active' ) ) {
					$item.removeClass( 'mts-cl-active' ).addClass( 'mts-cl-inactive' );
				} else {
					$item.addClass( 'mts-cl-active' ).removeClass( 'mts-cl-inactive' );
				}

				self.redraw_chart();

				return false;
            });
        },

		/**
         * Inits date range selector.
         */
		init_date_range_selector: function() {

            $( '#mts-cl-date-start' ).datepicker({
				changeMonth: true,
				changeYear: true
			});
            $( '#mts-cl-date-end' ).datepicker({
				changeMonth: true,
				changeYear: true
			});

			$( window ).load(function() {
				$( '#ui-datepicker-div' ).addClass( 'cmb2-element' );
			});
		},

		/**
         * Returns currently active selectors.
         */
        get_active_selectors: function() {

            var result = [];
            $(  '.mts-cl-selector-item.mts-cl-active'  ).each(function() {
                result.push( $( this ).data( 'selector' ) );
            });

            if ( ! result.length ) {
				return false;
			}

            return result;
        },

		/**
         * Draws the chart.
         */
        draw_chart: function( params ) {

            var options = $.extend( true, {}, this.defaults ),
				chartType = params.type || 'line',
				chartFunction = 'LineChart';

            this._params = params;

            if ( 'area' === chartType ) {
                chartFunction = 'AreaChart';
                options.legend.position = 'in';
                options.areaOpacity = 0.1;
            } else if ( 'column' === chartType ) {
                options.legend.position = 'none';
                chartFunction = 'ColumnChart';
            } else {
                options.legend.position = 'none';
                chartFunction = 'LineChart';
            }

            // Create the data table.
            var activeSelectors = this.get_active_selectors(),
				dataTable = new google.visualization.DataTable();

            var data = [];
            var columns = [];
            var colors = [];

            columns.push({
				type: 'date',
				title: 'Date'
			});

            // Building the columns and colors
            var row = window.cl_chart_data[0];
            for ( var column in row ) {

                if ( 'date' === column ) {
					continue;
				}

                // If the page contains selectors
                if ( activeSelectors && $.inArray( column, activeSelectors ) === -1 ) {
					continue;
				}

                // Column & title
                columns.push({
					type: 'number',
					title: row[column].title
				});

                colors.push( row[column].color );
            }

            // Building the data array
            for ( var index in window.cl_chart_data ) {
                var row = window.cl_chart_data[index];

                var chartRow = [ row.date.value ];
                for ( var column in row ) {

                    if ( 'date' === column ) {
						continue;
					}

                    // If the page contains selectors
                    if ( activeSelectors && $.inArray( column, activeSelectors ) === -1 ) {
						continue;
					}

                    chartRow.push( row[column].value );
                }
                data.push( chartRow );
            }

            for ( var i in columns ) {
				dataTable.addColumn( columns[i].type, columns[i].title );
			}
            options.colors = colors;
            dataTable.addRows( data );

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization[chartFunction]( document.getElementById( 'chart' ) );
            chart.draw( dataTable, options );
        },

        redraw_chart: function() {
            this.draw_chart( this._params );
        }

	};

	// Init
	$( document ).ready(function() {
		window.CL_Statistics.init();
	});

})( jQuery );
