import React, { Component } from 'react';
import { connect } from 'react-redux';
import classnames from 'classnames';

import './index.less';

import { 
	fetchReviewTopic, 
	fetchGetReply, 
	fetchToggleLike, 
	fetchToggleCollect, 
} from '../../assets/fetchApi/action';


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
		this.reply = this.reply.bind(this);
	}

	componentWillMount(){
		const { params } = this.props;
		const { token } = this.state;

		fetchReviewTopic({
			topic_id: params.id,
			token,
		})
			.then(res => {
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
			console.log(res);
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
	reply(){
		const { params, router } = this.props;

		router.push(`/subject/reply/${params.id}`);
	}	

	render(){
		const { detail, reply } = this.state;

		if(!detail){
			return null;
		}

		const { is_good, is_fav } = detail;

		return(
			<div className="reviewSubject">
				<div className="reviewSubject-title reviewSubject-field">{detail.title}</div>
				<div className="reviewSubject-body reviewSubject-field">
					<div className="reviewSubject-author">
						<div className="reviewSubject-userImage">
							<img src={detail.user_avatar} alt="" />
						</div>
						<div className="reviewSubject-userName">{detail.user_name}</div>
						<div className="reviewSubject-createTime">{detail.create_time}</div>

						<div className="reviewSubject-count clearfix">
							<span className={{}}>
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

							</div>
						)
					}
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
					<span onClick={this.reply}>
						<i className="iconfont icon-pinglun" />
						评论
					</span>
				</div>
			</div>
		)
	}
}

export default ReviewSubject;