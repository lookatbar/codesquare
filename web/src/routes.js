import React from 'react';
import { Route, IndexRoute } from 'react-router';
import App from './components/App';
import Home from './components/Home';
import Square from './components/Square';
import CreateSubject from './components/Create';
import ReviewSubject from './components/Review';
import User from './components/User';
import Ranking from './components/Ranking';
// import NotFound from './components/NotFound';

// 路由对应名称
export const routeMap = {
	'/home/square': '代码广场',
	'/home/square/create': '写笔记',
	'/home/square/detail': '详情',
	'/home/rank': '榜单',
	'/home/user': '我',
}


export default (
	<Route path="/" component={App}>
		<Route path="home" component={Home}>
			<Route path="square" component={Square}>
				<Route path="create" component={CreateSubject} />
				<Route path="review/:id" component={ReviewSubject} />
			</Route>
			<Route path="user" component={User} />
			<Route path="ranking" component={Ranking} />
		</Route>
	</Route>
);