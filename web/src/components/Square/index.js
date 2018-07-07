import React, { Component } from 'react';
import './index.less';
import { connect } from 'react-redux';
import { fetchGetTopic } from '../../assets/fetchApi/action';

import Tabbar from '../common/Tabbar';
import { tabs } from './config';
import { Link } from 'react-router';

import InfiniteScroll from 'react-infinite-scroll-component';

const initPage = 1;

const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class Square extends Component{
	constructor(props){
		super(props);

		const { token } = props.userInfo;

		this.state = {
			token,
			page_index: initPage,
			tabs: [],
			topic_type: tabs[0].topic_type,

			list: [],
			record_count: 10,

			prevData: [],
			nextData: [],
			hasMore: true,
		}

		this.onChangeTab = this.onChangeTab.bind(this);
		this.onRefresh = this.onRefresh.bind(this);
		this.onTurnPage = this.onTurnPage.bind(this);
		this.onReview = this.onReview.bind(this);
	}

	componentDidMount(){
		this.loadData();
	}
	// 修改分类
	onChangeTab(target){
		const topic_type = target.topic_type;
		if(topic_type !== this.state.topic_type){
			this.setState({
				list: [],
				page_index: initPage,
				topic_type,
				hasMore: true,
			});
		}

		this.loadData({
			...this.state,
			page_index: initPage,
			topic_type, 
		});
	}

	onRefresh(){
		this.setState({
			list: [],
			page_index: initPage,
			hasMore: true,
		});

		this.loadData({
			...this.state,
			page_index: initPage,
			hasMore: true,
		});
	}

	onTurnPage(index){
		// console.log('加载更多');
		let { page_index } = this.state;
		page_index += 1;

		this.setState({
			page_index,
		});

		this.loadData({
			...this.state,
			page_index,
		});
	}

	onReview(target){
		const { router } = this.props;
		router.push(`/subject/review/${target.topic_id}`);
	}

	loadData(param = this.state){
		const { token, page_index, topic_type } = param;

		if(!token){
			setTimeout(() => {
				this.loadData(param);
			}, 500);
			return;
		}

		fetchGetTopic({
			token,
			page_index,
			topic_type,
		}).then(res => {
			const { list } = this.state;
			const {
				data,
				record_count, 
			} = res;

			const newList = list.concat(data);
			let hasMore = newList.length < record_count;

			this.setState({
				list: newList,
				record_count, 
				hasMore,
			});
		});
	}

	render(){
		const { topic_type, list, hasMore, record_count } = this.state;

		return (
			<div className="square transition-item">
				<div className="square-tabs">
					<Tabbar 
						name="topic_type_name" 
						keyword="topic_type" 
						tabs={tabs} 
						current={topic_type} 
						onSelect={this.onChangeTab} />
				</div>
				<div className="square-content">
					<InfiniteScroll
						dataLength={list.length} //This is important field to render the next data
						next={this.onTurnPage}
						hasMore={hasMore}
						loader={<h4>Loading...</h4>}
				
						// below props only if you need pull down functionality
						refreshFunction={this.onRefresh}
						pullDownToRefresh
						pullDownToRefreshContent={
						  <h3 style={{textAlign: 'center'}}>&#8595; </h3>
						}
						releaseToRefreshContent={
						  <h3 style={{textAlign: 'center'}}>&#8593; 释放刷新</h3>
						}>
						{
							list.map((item, index) => {
								return (
									<div className="square-node" key={item.topic_id} onClick={() => this.onReview(item)}>
										<div className="square-node-title">{item.title}</div>
										<div className="square-node-content">{item.content}</div>
										<div className="square-node-author">{item.user_name}</div>
										<div className="square-node-detail clearfix">
											<span>
												<i className="iconfont icon-liulan2" />
												{item.view_count}
											</span>
											<span>
												<i className="iconfont icon-weibiaoti-" />
												{item.good_count}
											</span>
											<span>
												<i className="iconfont icon-pinglun" />
												{item.reply_count}
											</span>
										</div>
									</div>
								)
							})
						}
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