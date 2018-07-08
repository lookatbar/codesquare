import React, { Component } from 'react';
import { connect } from 'react-redux';
import classnames from 'classnames';

import './index.less';

import { 
	fetchReviewTopic, 
	fetchGetReply, 
	fetchToggleLike, 
	fetchToggleCollect, 
	fetchAccept, 
} from '../../assets/fetchApi/action';

import { 
	showLoading, 
	hideLoading, 
	showToast, 
	hideToast, 
} from '../common/Loading/loadingRedux';


const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class ReviewSubject extends Component{
	constructor(props){
		super(props);

		const { token } = props.userInfo;

		this.state = {
			token,
			detail: null,
			reply: [],
		}

		this.like = this.like.bind(this);
		this.collect = this.collect.bind(this);
		this.onReply = this.onReply.bind(this);
		this.onAccept = this.onAccept.bind(this);
	}

	componentWillMount(){
		const { params } = this.props;
		const { token } = this.state;

		fetchReviewTopic({
			topic_id: params.id,
			token,
		}).then(res => {
				console.log(res);
				this.setState({
					detail: res.data,
				})
			});

		fetchGetReply({
			token,
			topic_id: params.id,
			page_size: 100,
			page_index: 1,
		}).then(res => {
			this.setState({
				reply: res.data,
			});
		})
	}
	// 点赞
	like(){
		console.log('切换点赞...');
		const { params } = this.props;
		const { token, detail } = this.state;
		const { is_good, good_count } = detail;

		fetchToggleLike(is_good, params.id, token)
			.then(res => {
				let new_is_good = is_good === 0 ? 1 : 0;
				let new_good_count = is_good === 0 ? (good_count + 1) : (good_count - 1);
				this.setState({
					detail: {
						...detail,
						is_good: new_is_good,
						good_count: new_good_count,
					}
				});
			});
	}
	// 收藏
	collect(){
		console.log('切换收藏...');
		const { params } = this.props;
		const { token, detail } = this.state;
		const { is_fav } = detail;

		fetchToggleCollect(is_fav, params.id, token)
			.then(res => {
				let new_is_fav = is_fav === 0 ? 1 : 0;
				this.setState({
					detail: {
						...detail,
						is_fav: new_is_fav,
					}
				});
			})
	}
	// 回复跳转
	onReply(){
		const { params, router } = this.props;

		router.push(`/subject/reply/${params.id}`);
	}	
	// 采纳回答
	onAccept(target){
		const { token, detail } = this.state;
		const { params, dispatch } = this.props;
		dispatch(showLoading());

		fetchAccept({
			token,
			topic_id: params.id,
			reply_id: target.reply_id,
		}).then(res => {
			dispatch(hideLoading());
			dispatch(showToast('已采纳'));

			this.setState({
				detail: {
					...detail,
					accept_reply_id: target.reply_id,
				}
			});

			setTimeout(() => {
				dispatch(hideToast('已采纳'));
			}, 2000);
		});
	}
	// 渲染采纳按钮
	getAcceptBtn(reply){
		const { detail } = this.state;
		const { is_author, accept_reply_id } = detail;
		if(is_author !== 1){
			return null;
		}
		if(accept_reply_id > 0 && reply.reply_id === accept_reply_id){
			return <span className="accepted">已采纳</span>
		}else if(accept_reply_id === '0'){
			return (
				<button type="button" 
								onClick={() => this.onAccept(reply)}
								className="reviewSubject-btn-accept">采纳</button>
			)
		}
	}

	render(){
		const { detail, reply } = this.state;

		if(!detail){
			return null;
		}

		const { is_good, is_fav } = detail;

		return(
			<div className="reviewSubject">
				<div className="reviewSubject-inner">
					<div className="reviewSubject-title reviewSubject-field">{detail.title}</div>
					<div className="reviewSubject-body reviewSubject-field">
						<div className="reviewSubject-author">
							<div className="reviewSubject-userImage">
								<img src={detail.user_avatar} alt="" />
							</div>
							<div className="reviewSubject-userName">{detail.user_name}</div>
							<div className="reviewSubject-createTime">{detail.create_time}</div>

							<div className="reviewSubject-count clearfix">
								<span>
									<i className="iconfont icon-liulan2" />
									{detail.view_count}
								</span>
								<span>
									<i className="iconfont icon-weibiaoti-" />
									{detail.good_count}
								</span>
								<span>
									<i className="iconfont icon-pinglun" />
									{detail.reply_count}
								</span>
							</div>


						</div>

						<div className="reviewSubject-content">
							{detail.content}
						</div>
					</div>

					<div className="reviewSubject-reply reviewSubject-field">
						<div className="reviewSubject-reply-title">评论</div>
						{
							reply.map(item => 
								<div key={item.reply_id} className="reviewSubject-reply-wrapper">
									<div className="reviewSubject-reply-avatar">
										<img src={item.avatar} alt="" />
									</div>
									<div className="reviewSubject-reply-author">{item.user_name}</div>
									<div className="reviewSubject-reply-content">{item.content}</div>
									{ this.getAcceptBtn(item) }
								</div>
							)
						}
					</div>
				</div>

				<div className="reviewSubject-tools">
					<span onClick={this.like} className={classnames({is_good: is_good !== 0})}>
						<i className="iconfont icon-zan" />
						赞·{detail.good_count}
					</span>
					<span onClick={this.collect} className={classnames({is_fav: is_fav !== 0})}>
						<i className="iconfont icon-shoucang" />
						收藏
					</span>
					<span onClick={this.onReply}>
						<i className="iconfont icon-pinglun" />
						评论
					</span>
				</div>
			</div>
		)
	}
}

export default ReviewSubject;