import React, { Component } from 'react';
import { connect } from 'react-redux';
import './index.less';
import { Link } from 'react-router';

import {
	fetchGetUserPublish,
	fetchGetUserFav,
} from '../../assets/fetchApi/action';

const mapStateToProps = ({userInfo}) => ({
	userInfo,
});

@connect(mapStateToProps)
class Favorite extends Component{
	constructor(props){
		super(props);

		this.state = {
			list: [],
		};
	}

	componentDidMount(){
		const { route, userInfo } = this.props;

		let method = {
			'public': fetchGetUserPublish,
			'favorite': fetchGetUserFav,
		}[route.path];

		method(userInfo.token)
			.then(res => {
				console.log(res);
				this.setState({
					list: res.data,
				})
			})
	}


	render(){
		const { list } = this.state;
		console.log(list);

		return (
			<div className="favorite">
				{
					list.map(item => 
						<Link key={item.topic_id} 
									className="favorite-item" 
									to={`/subject/review/${item.topic_id}`}>
							<div className="favorite-title">{item.title}</div>
							<div className="favorite-time">
								{item.create_time || item.user_name}
							</div>
							<div className="favorite-detail clearfix">
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
						</Link>
					)
				}
			</div>
		)
	}
}

export default Favorite;