/*
 * Uses jQuery and the Class extension to process Ajax requests.
 * Wraps DbWrapper.php (backend) functionality to be accessed by the frontend.
 * 
 */
var DbWrapper = Class.create({ table: '',
	get: function( id, callback ) {
		$.getJSON( 'connect.php', { table: this.table, method: 'get', id: id }, callback );
	},
	getAll: function( callback, params ) {
		if ( params == null )
			params = {};
		params.table = this.table;
		params.method = 'getAll';
		$.getJSON( 'connect.php', params, callback );
	}
});
