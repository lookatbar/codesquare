import React from 'react';
import { Route, Redirect, IndexRedirect } from 'react-router';
import App from './components/App';
import Home from './components/Home';
import Square from './components/Square';
import User from './components/User';
import Ranking from './components/Ranking';
import Market from './components/Market';

import Subject from './components/Subject';
import CreateSubject from './components/CreateSubject';
import ReviewSubject from './components/ReviewSubject';
import Reply from './components/Reply';

// 路由对应名称
export const routeMap = {
	'/home/square': '代码广场',
	'/home/ranking': '榜单',
	'/home/market': 'M商城',
	'/home/user': '我',

	'/subject/create': '写笔记',
	'/subject/review': '详情',
}

export default (
	<Route path="/" component={App}>
		<IndexRedirect to="/home/square" />
		<Route path="home" component={Home}>
			<Route path="square" component={Square} />
			<Route path="ranking" component={Ranking} />
			<Route path="market" component={Market} />
			<Route path="user" component={User} />
		</Route>
		<Route path="subject" component={Subject}>
			<Route path="create" component={CreateSubject} />
			<Route path="review/:id" component={ReviewSubject} />
			<Route path="reply/:id" component={Reply} />
		</Route>
		<Redirect from="*" to="/home/square" />
	</Route>
);