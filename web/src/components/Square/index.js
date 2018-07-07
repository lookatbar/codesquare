import React, { Component } from 'react';
import './index.less';
// import { connect } from 'react-redux';

import Tabbar from '../common/Tabbar';
import { tabs } from './config';
import { Link } from 'react-router';

import InfiniteScroll from 'react-infinite-scroll-component';

const initPage = 0;

class Square extends Component{
	constructor(props){
		super(props);


		this.state = {
			page_index: initPage,
			tab: tabs[0].key,

			prevData: [],
			nextData: [],
			hasMore: true,

		}

		this.onChangeTab = this.onChangeTab.bind(this);
		this.onRefresh = this.onRefresh.bind(this);
		this.onTurnPage = this.onTurnPage.bind(this);
	}
	// 修改分类
	onChangeTab(target){
		const tab = target.key;
		if(tab !== this.state.tab){
			this.setState({
				page_index: initPage,
				tab,
			});
		}
	}

	onRefresh(){
		this.setState({
			page_index: initPage,
		})
	}

	onTurnPage(index){
		console.log('加载更多');
		let { page_index, tab } = this.state;

		this.setState({
			page_index: page_index + 1,
		})
	}

	render(){
		const { tab } = this.state;

		return (
			<div className="square transition-item">
				<div className="square-tabs">
					<Tabbar tabs={tabs} current={tab} onSelect={this.onChangeTab} />
				</div>
				<div className="square-content">
				代码广场
					<InfiniteScroll>

					</InfiniteScroll>
				</div>
				<Link 
					className="square-create iconfont icon-tianjiajiahaowubiankuang"
					to="/subject/create" />
			</div>
		)
	}
}

export default Square;