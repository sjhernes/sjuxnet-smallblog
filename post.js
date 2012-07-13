function PostCtrl($scope, $http) {
    $scope.getPosts = function() {
	$http.get( "posts.php", {dd:"d"}).success(function(data, status) { $scope.posts = data; });
    };
    $scope.newPost = function(f) {
	$http.post( "posts.php", { "title":f.title, "content":f.content, "psw":f.psw})
	    .success(function(data, status) {if(data.split(';')[0] == 'true'){
		    $scope.posts.splice(0, 0, {id:data.split(';')[1], title:f.title, content:f.content});
	    }});
    };
    $scope.updatePost = function(p, form) {
	$http.post( "posts.php", { "id":p.id, "title":p.title,"content":p.content,"psw":form.psw})
	    .success(function(data, status) { $scope.getPosts(); }); 
    };
}