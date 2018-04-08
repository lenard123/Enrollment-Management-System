function URLSearchParams(){
	var a = {
    	x:"",
		append: function(key, val){
			this.x += key+'='+escape(val)+'&';
		},
    	a: function(){
    		return this.x;
    	}
    }
    return a;
}			
